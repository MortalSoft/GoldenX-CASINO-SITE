const app = require("express")(),
fs = require("fs");
var Redis = require('ioredis');
var redis = new Redis();
var RandomOrg = require('random-org');
// const curl = new (require( 'curl-request' ))();

const { curly } = require('node-libcurl')

var request = require('request');

var requestify = require('requestify');
domain = 'https://mortalsoft.online';

var crypto = require('crypto'); 

const mysql = require('mysql')
const util = require('util')
var client = mysql.createConnection({
    host: 'localhost',
    user: 'replace_user',
    password: 'replace_password',
    database: 'replace_db',
});
client.query = util.promisify(client.query);
client.query("SET SESSION wait_timeout = 604800");

const server = require("https").createServer({
    key: fs.readFileSync('/etc/letsencrypt/live/mortalsoft.online/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/mortalsoft.online/fullchain.pem')
}),
io = require("socket.io")(server, {
    cors: {
        origin: "https://mortalsoft.online",
        methods: ["GET", "POST"]
    }
});


server.listen(2083, () => {
    //  console.log('server listen 2083');
});

usersOnline = [];
gamesOnline = [[],[],[],[],[],[],[],[],[]];

io.on('connection', async (socket) => {


    socket.on('getUsersOnline', function() {
        socket.emit('usersOnline', usersOnline.length);
    });

    socket.on('getGamesOnline', function() {
        // sendGamesOnline(gamesOnline)
        socket.emit('gamesOnline', JSON.stringify(gamesOnline));

    });

    socket.on('subscribe',function(room){
        
        try{
            room_split = room.split('_')
            if (room_split[0] == 'roomUser'){
                
                if(!usersOnline.includes(room_split[1])){
                    usersOnline.push(room_split[1])
                }

                io.sockets.emit('usersOnline', usersOnline.length);

                console.log(usersOnline)
                console.log('[socket]','join user with id ',room_split[1])
            }

            if (room_split[0] == 'roomGame'){
                clearUserGame(room_split[2])
                
                if(!gamesOnline[room_split[1]].includes(room_split[2])){
                    gamesOnline[room_split[1]].push(room_split[2])
                }

                // sendGamesOnline(gamesOnline)
                io.sockets.emit('gamesOnline', JSON.stringify(gamesOnline));

                console.log(gamesOnline)
                console.log('[socket]','join game', room_split[1], 'with id ',room_split[2])
            }


            console.log('[socket]','join room :',room)
            socket.join(room);
            socket.to(room).emit('user joined', socket.id);
        }catch(e){
            console.log('[error]','join room :',e);
            socket.emit('error','couldnt perform requested action');
        }
    })

    socket.on('disconnecting', function(){
        console.log("disconnecting.. ", socket.id)
        notifyFriendOfDisconnect(socket)
    });

    function notifyFriendOfDisconnect(socket){
        var rooms = Object.keys(socket.rooms);
        rooms.forEach(function(room){
            room_split = room.split('_')
            if (room_split[0] == 'roomGame'){
                
                const index = gamesOnline[room_split[1]].indexOf(room_split[2]);
                if (index > -1) { // only splice array when item is found
                  gamesOnline[room_split[1]].splice(index, 1); // 2nd parameter means remove one item only
              }

                // sendGamesOnline(gamesOnline)
                io.sockets.emit('gamesOnline', JSON.stringify(gamesOnline));
                console.log(gamesOnline)
                console.log('[socket]','left game', room_split[1], ' with id ',room_split[2])
            }

            if (room_split[0] == 'roomUser'){
                
                const index = usersOnline.indexOf(room_split[1]);
                if (index > -1) { // only splice array when item is found
                  usersOnline.splice(index, 1); // 2nd parameter means remove one item only
              }

              io.sockets.emit('usersOnline', usersOnline.length);
              console.log(usersOnline)
              console.log('[socket]','left user with id ',room_split[1])
          }

          
          socket.to(room).emit('connection left', socket.id + ' has left');
      });
    }

    
});

function clearUserGame(user_id){
    let i = 0;
    while (i < 8) {
        const index = gamesOnline[i].indexOf(user_id);
        if (index > -1) { // only splice array when item is found
            gamesOnline[i].splice(index, 1); // 2nd parameter means remove one item only
        }
        
        i++;
    }
}

io.on('connection', function(socket) {
    socket.on('giveCrash', async function(msg) {
        if(statusCrashGo == 1){
            let gameId = parseInt(msg.gameId);
            
            var gameCrash = await client.query('SELECT * FROM crash WHERE id = ?', [gameId])

            crash_userId = gameCrash[0].user_id
            crash_userBet = gameCrash[0].bet

            crash_userCoeff = now_iks
            crash_userWin = crash_userCoeff * crash_userBet        

            await client.query('UPDATE crash SET result = ?  WHERE id = ?', [crash_userCoeff, gameId])

            io.sockets.emit('crashUpdate', {
                type: '1',
                game_id: gameId,
                win_user: crash_userWin,
                user_id: crash_userId,
                coeff: crash_userCoeff
            })

            bankCrash -= crash_userWin
            winAllCrash -= crash_userBet

            console.log('Bank: '+bankCrash+' WinAllCrash: '+winAllCrash)

            var user_bd = await client.query('SELECT balance, demo_balance, type_balance FROM users WHERE id = ?', [crash_userId])

            type_balance = user_bd[0]['type_balance']

            if(type_balance == 0){
                balanceLast = user_bd[0]['balance']
                balanceNew = crash_userWin + user_bd[0]['balance']
                await client.query('UPDATE users SET balance = ?  WHERE id = ?', [balanceNew, crash_userId])
            }else{
                balanceLast = user_bd[0]['demo_balance']
                balanceNew = crash_userWin + user_bd[0]['demo_balance']
                await client.query('UPDATE users SET demo_balance = ?  WHERE id = ?', [balanceNew, crash_userId])
            }
            

            await io.sockets.emit('crashNoty', {
                balanceLast, balanceNew,
                win: crash_userWin,
                user_id: crash_userId
            })

        }
        


    });

    socket.on('boomCrash', async function(msg) {
        crashBoom = 1
    });
});




io.sockets.on('connection', function(socket) {

    socket.on('updateTournier', function(msg) {
        id = parseInt(msg.id);
        time_to_type_1 = parseInt(msg.time_to_type_1);
        time_to_type_2 = parseInt(msg.time_to_type_2);

        if(time_to_type_1 < 0){
            time_to_type_1 = 0
        }

        setTimeout(() => updateTournier(id, 1), time_to_type_1 * 1000);
        setTimeout(() => updateTournier(id, 2), time_to_type_2 * 1000);

    });


    socket.on('message', function(data) {
        var newData = data.message;
        
    })    


    socket.on('WHEEL_CONNECT', (e) => {
        socket.emit('WHEEL_GET', {bonusWheelTime, TipeWheel, coefficients, wheelRotate, wheelPlus, wheelTime, wheelStatus, bonusArr, statusBonus })
    })

    socket.on('X100_CONNECT', (e) => {
        socket.emit('X100_GET', {x100Rotate, x100Plus, x100Time, statusBonusX100, x100BonusAvatars, x100Status })
    })

    socket.on('KENO_CONNECT', (e) => {
        socket.emit('KENO_GET', { selectNumberKeno, bonusKeno })
    })

    socket.on('JACKPOT_CONNECT', (e) => {
        socket.emit('JACKPOT_GET', { avatarJackpot, plusJackpot, statusJackpot, cashHantJackpot, timerJackpotAnimate, timerCashHantJackpot })
    })

    socket.on('BOOM_CONNECT', (e) => {
        socket.emit('BOOM_GET', { statusBoom, blocksBoom, timeBoom, bonusBoom, dicesBoom })
    })

    // socket.on('PING_CONNECT', (e) => {
    //     socket.emit('PING_GET')
    // })
}); 


async function updateTournier(id, type) {
    const tournier = await client.query('SELECT * FROM tourniers WHERE id = ?', [id])

    game_id = tournier[0].game_id

    if(game_id == 0){
        photo_start = 'photo670021108_457241760';
        photo_end = 'photo670021108_457241685';
    }else{
        photo_start = 'photo670021108_457242087';
        photo_end = 'photo670021108_457242090';
    }

    if(type == 1){
        await client.query('UPDATE tourniers SET status = ? WHERE id = ?', [1, id])
    }


    if(type == 2){
        await client.query('DELETE FROM tourniers WHERE id = ?', [id])
    }

}





redis.psubscribe('*', function(error, count) {

});

redis.on('pmessage', function(pattern, channel, message) {
    io.emit(channel, message);

});


function x100_bot() {
    console.log(domain)
    requestify.request(domain+'/x100bot', {
      method: 'GET'
  })
    .then(function(response) {
        console.log('responsebody', response.body);
        console.log('response headers',response.getHeaders());
        console.log('responseheader Accept', response.getHeader('Accept'));
        console.log('response code', response.getCode());
        console.log('responsebody RAW', response.body);
    })
    .fail(function (response) {
        console.log('response Error', response.getCode());
    })
    ;





    
}








function TIMES(e) {
    if (e < 10) {
        return '0' + e
    }
    return e
}

function shuffle(e) {
    return e.sort(() => Math.random() - 0.5);
}

function rand(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}


// WHEEL


const doubleData = {
    0: "30",
    1: "7",
    2: "3",
    3: "2",
    4: "3",
    5: "2",
    6: "5",
    7: "3",
    8: "2",
    9: "5",
    10: "2",
    11: "14",
    12: "2",
    13: "3",
    14: "2",
    15: "bonus",
    16: "7",
    17: "5",
    18: "2",
    19: "5",
    20: "7",
    21: "2",
    22: "14",
    23: "2",
    24: "3",
    25: "5",
    26: "7",
    27: "3",
    28: "2",
    29: "3"
    
}



function wheelColorCoff(e) {
    var coffNumber = null
    switch (e) {
        case '2':
        coffNumber = 2
        break;
        case '3':
        coffNumber = 3
        break;
        case '5':
        coffNumber = 5
        break;
        case '7':
        coffNumber = 7
        break;
        case '14':
        coffNumber = 14
        break;
        case '30':
        coffNumber = 30
        break;
        case 'bonus':
        coffNumber = 'bonus'
        break;      
    }
    return coffNumber
}

const bonusCoff = {
    x2: 15,
    x3: 15,
    x5: 15,
    x30: 15,
}
async function bonusColorCoff(){
    var colorse = []
    for(let i=0;i<Object.keys(bonusCoff).length;i++){
        for(let j=0;j<bonusCoff[Object.keys(bonusCoff)[i]];j++){
            colorse.push(Object.keys(bonusCoff)[i])
        }
    }
    return await shuffle(colorse)
}
async function bonusCoffs(){
    var arr = []
    return await shuffle(arr)
}


var wheelPlus = 0
var wheelTime = 30
var wheelRotate = 0
var wheelStatus = 0

var bonusArr = []
var bonusBonus = {}
var statusBonus = 0

var wheelYmn = 1;

async function goWheel() {
    var preFinishWheel = false;
    WHEEL_START = 0
    wheelStatus = 0
    await client.query('UPDATE settings SET status_wheel = ?', [0])
    var intervalwheel = setTimeout(async function wait_wheel() {
        const sw = await client.query('SELECT count(*) FROM wheels')
        io.sockets.emit('WHEEL_TIME', {
            time: 30,
            text: 'Ожидание игроков',
            bet: 'on'
        })
        if (sw[0]['count(*)'] > 0) {
            if(!preFinishWheel) {
                preFinishWheel = true
                startWheel(30)

                clearTimeout(intervalwheel)
                return
            }
        }else{
            console.log('wait')
            var intervalwheel = setTimeout(wait_wheel, 1000);
        }
    }, 1000);

    
}



goWheel()



function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}



function shuffle_sl(arr){
	var j, temp;
	for(var i = arr.length - 1; i > 0; i--){
		j = Math.floor(Math.random()*(i + 1));
		temp = arr[j];
		arr[j] = arr[i];
		arr[i] = temp;
	}
	return arr;
}

function sleep(milliseconds) {
  const date = Date.now();
  let currentDate = null;
  do {
    currentDate = Date.now();
} while (currentDate - date < milliseconds);
}

async function randOrgJackpot(){
    await requestify.request(domain+'/generate_jackpotnumber', {
      method: 'GET'
  })
    .then(async function(response) {
        response = response.body;
        console.log(response)
        return 'True'
    })
    .fail(async function (response) {
        console.log('responsebody', response.body);
        console.log('response Error', response.getCode());
        return 'False'

    });
}
async function randOrg(game) {
 await requestify.request(domain+'/generate_number_'+game, {
  method: 'GET'
})
 .then(async function(response) {
    response = response.body;
    console.log(response)
    response = JSON.parse(response)
    if(game == 'x30'){
        rand_keyX30 = response.number
        rand_randomX30 = response.random
        rand_signatureX30 = response.signature
    }else{
        rand_keyX100 = response.number
        rand_randomX100 = response.random
        rand_signatureX100 = response.signature
    }
    return 'True'       
})
 .fail(async function (response) {
    console.log('responsebody', response.body);
    console.log('response Error', response.getCode());
    return 'False'
});


}

async function winUserX100(){
  await requestify.request(domain+'/winx100', {
      method: 'GET'
  })
  .then(async function(response) {
    response = response.body;
    console.log(response)
    return 'True'
})
  .fail(async function (response) {
    console.log('response Error', response.getCode());
    return 'False';

});  
}

async function winUserWheel(){
    await requestify.request(domain+'/winwheel', {
      method: 'GET'
  })
    .then(async function(response) {
        response = response.body;
        console.log(response)
        return 'True'
    })
    .fail(async function (response) {
        console.log('response Error', response.getCode());
        return 'False';

    });
}

rot_0 = 0

var WHEEL_START = 0;
var MAX_RANDOM_KEY_ID = 10;
var MIN_RANDOM_KEY_ID = 1;
var global_rand_key = -1;
var global_rand_random = -1;
var global_rand_signature = -1;
var TipeWheel = 'cubic-bezier(0, 0.49, 0, 1)';
var coefficients = [2, 3, 5, 7, 14, 30]
var bonusWheelTime = 0
var rand_keyX30 = 0
var rand_randomX30 = 0
var rand_signatureX30 = 0

function sleepWait(){
    TIMER_WHEEL_WAIT = 5

    setTimeout(function run_wait() {
      TIMER_WHEEL_WAIT -= 1

      io.sockets.emit('WHEEL_TIME', {
        time: TIMER_WHEEL_WAIT,
        text: 'Генерируем число...',
        bet: 'off'
    })

      console.log('wait_wheel')


      if (TIMER_WHEEL_WAIT <= 0) {
        return
    }

    setTimeout(run_wait, 1000);

}, 1000);
}

function startWheel(TIMER_WHEEL){
    console.log('go')
    var TIMER_WHEEL = TIMER_WHEEL;
    var preFinishWheel = false;


    const cw = setInterval(async () => {
        TIMER_WHEEL -= 1
        io.sockets.emit('WHEEL_TIME', {
            time: TIMER_WHEEL,
            text: 'Прокрутка через',
            bet: 'on'
        })
        if (TIMER_WHEEL <= 1) {
            await client.query('UPDATE settings SET status_wheel = ?', [1])
            
        }

        if (TIMER_WHEEL <= 0 && !preFinishWheel) {
            preFinishWheel = true
            await clearInterval(cw)

            var arr = []

            var totalCoff = false
            var coffs = 1

            var bonus = false
            var dict = [];

            var colorCoffResult = null

            //// RAN

            io.sockets.emit('WHEEL_TIME', {
                time: 0,
                text: 'Генерируем число...',
                bet: 'off'
            })

            type = 'False'
            while (type == 'False'){
                type = await randOrg('x30')
            }

            
            
            //////////////////////

            const setting = await client.query('SELECT * FROM settings')


            var mult_bonus = setting[0].mult_bonus;
            var coeff_bonus = setting[0].coeff_bonus;

            var wheel_win = setting[0].wheel_win;
            var youtube = setting[0].youtube;
            var auto_wheel = setting[0].auto_wheel;
            if(auto_wheel == 0){
                youtube = 1
            }



            ////////////////////////////////////// 

            var rand_key_x30 = rand_keyX30
            var rand_random_x30 = rand_randomX30
            var rand_signature_x30 = rand_signatureX30

            number_double = rand_key_x30
            console.log('NUMB '+number_double)

            colorCoffResult = doubleData[number_double]
            
            wheelPlus = rand(0, 2)
            if(rot_0 == 0){
                rot_0 = 1
                umn = 360
            }else{
                umn = 360 * 9
                rot_0 = 0
            }
            wheelRotate = 360 / 30 * (number_double) + umn;
            TipeWheel = 'cubic-bezier(0, 0.49, 0, 1)'
            io.sockets.emit('WHEEL_START', {wheelStatus:1, colorCoffResult, wheelPlus: wheelPlus, wheelTime: 30,TipeWheel, wheelRotate })
            wheelStatus = 1
            var finish = 30
            var finisherwheel = false
            var FINISH_WHEEL = setTimeout(async function fin_w_1() {

                finish -= 1
                wheelTime = finish
                

                io.sockets.emit('WHEEL_TIME', {
                    time: finish,
                    text: 'Новый раунд через',
                    bet: 'off'
                })


                if (finish == 0 && !finisherwheel) {
                    finisherwheel = true
                    
                    await clearTimeout(FINISH_WHEEL)                                    

                    var coffNumberX30 = await wheelColorCoff(colorCoffResult)                                      

                    var coeff_x30 = coffNumberX30


                    if (coeff_x30 == "bonus"){
                        var arr = []
                        const color = await bonusColorCoff()
                        const coff = ['2x', '2x', '2x', '2x','3x','4x', '2x', '3x', '2x','6x','7x','3x','3x', '4x','4x', '5x', '6x', '7x']// ''
                        shuffle(coff)
                        const coffWin = coff[await rand(0, coff.length - 1)]
                        var isBonus = false

                        for (let i = 0; i < 100; i++) {
                            arr.push({
                                multiplayer: [coff[rand(0, coff.length - 1)]]

                            })
                        }
                        var totalCoff = false
                        var coffs = 1
                        var cx = await bonusColorCoff()
                        cx = cx[0]
                        var bonus = false

                        isBonus = Number(coffWin.replace('x', ''))

                        coffs = await wheelColorCoff(cx)

                        arr[43] = { multiplayer: [isBonus + 'x'] }
                        if(mult_bonus != 'false'){
                            isBonus = mult_bonus
                            arr[43] = { multiplayer: [mult_bonus + 'x'] }
                        }
                        

                        wheelYmn *= isBonus;
                        coefficients = coefficients.map(function(x) { return x * isBonus; });

                        plus = rand(3, 45)

                        bonusArr = arr
                        bonusBonus = bonus
                        statusBonus = 1
                        bonusWheelTime = 10


                        io.sockets.emit('WHEEL_BONUS', {
                            bonusArr,
                            bonusWheelTime
                        })



                        var finish_bonus = 10
                        var BONUS_WHEEL = setTimeout(async function bonus_run() {
                            finish_bonus -= 1
                            bonusWheelTime = finish_bonus
                            io.sockets.emit('WHEEL_TIME', {
                                time: finish_bonus,
                                text: 'Бонусная игра',
                                bet: 'off'
                            })
                            if(finish_bonus == 6){
                             await client.query('UPDATE settings SET wheel_win="false"')

                         }
                         if (finish_bonus <= 0){

                            await client.query('INSERT INTO wheel_history (number,coff, random, signature) VALUES (?,?, ?, ?)', [number_double,colorCoffResult, rand_random_x30, rand_signature_x30])


                            io.sockets.emit('WHEEL_NEW_COEFF', {
                                coefficients: coefficients,
                            })
                            statusBonus = 2


                            setTimeout(() => startWheel(1), 2000);
                            return;
                        }else{
                            var BONUS_WHEEL = setTimeout(bonus_run, 1000);
                        }

                    }, 1000);


                        

                    }

                    else{



                        await client.query('INSERT INTO wheel_history (number,coff, random, signature) VALUES (?,?, ?, ?)', [number_double,colorCoffResult, rand_random_x30, rand_signature_x30])
                        await client.query('UPDATE settings SET youtube=0,wheel_win="false",mult_bonus="false",coeff_bonus="false",wheelYmn = ?, wheelWinNumber = ?', [wheelYmn, coffNumberX30])

                        console.log('Win wait...')

                        type = 'False'
                        while (type == 'False'){
                            type = await winUserWheel()
                        }


                        console.log('Win done...')
                        wheelYmn = 1
                        statusBonus = 0
                        coefficients = [2, 3, 5, 7, 14, 30]


                        await client.query('TRUNCATE wheels')
                        await client.query('UPDATE wheel_anti SET win = 0')



                        const history = await client.query('SELECT number,id,coff,random,signature FROM wheel_history ORDER BY id DESC LIMIT 0,50')




                        io.sockets.emit('WHEEL_FINISH', { history, colorCoffResult })
                        wheelStatus = 0
                        setTimeout(() => io.sockets.emit('WHEEL_CLEAR'), 1000);

                        setTimeout(goWheel, 1000)

                    }

                    return
                }


                var FINISH_WHEEL = setTimeout(fin_w_1, 1000);
            }, 1000);



}


}, 1000)


}


// END WHEEL

// X100


function X100ColorCoff(e) {
    var coffNumber = null
    switch (e) {
        case '2':
        coffNumber = 2
        break;
        case '3':
        coffNumber = 3
        break;
        case '10':
        coffNumber = 10
        break;
        case '15':
        coffNumber = 15
        break;
        case '20':
        coffNumber = 20
        break;  
        case '100':
        coffNumber = 100
        break;      
    }
    return coffNumber
}



const x100Data = {
    0: "20",
    1: "2",
    2: "3",
    3: "2",
    4: "15",
    5: "2",
    6: "3",
    7: "2",
    8: "20",
    9: "2",
    10: "15",
    11: "2",
    12: "3",
    13: "2",
    14: "3",
    15: "2",
    16: "15",
    17: "2",
    18: "3",
    19: "10",
    20: "3",
    21: "2",
    22: "10",
    23: "2",
    24: "3",
    25: "2",

    26: "100",
    27: "2",
    28: "3",
    29: "2",
    30: "10",
    31: "2",
    32: "3",
    33: "2",
    34: "3",
    35: "2",
    36: "15",
    37: "2",
    38: "3",
    39: "2",
    40: "3",
    41: "2",
    42: "20",
    43: "2",
    44: "3",
    45: "2",
    46: "10",
    47: "2",
    48: "3",
    49: "2",
    50: "10",

    51: "2",
    52: "3",
    53: "2",
    54: "15",
    55: "2",
    56: "3",
    57: "2",
    58: "3",
    59: "2",
    60: "10",
    61: "20",
    62: "3",
    63: "2",
    64: "3",
    65: "2",
    66: "15",
    67: "2",
    68: "10",
    69: "2",
    70: "3",
    71: "2",
    72: "20",
    73: "2",
    74: "3",
    75: "2",

    76: "15",
    77: "2",
    78: "3",
    79: "2",
    80: "10",
    81: "2",
    82: "3",
    83: "2",
    84: "3",
    85: "2",
    86: "10",
    87: "2",
    88: "3",
    89: "2",
    90: "3",
    91: "2",
    92: "10",
    93: "2",
    94: "3",
    95: "2",
    96: "3",
    97: "2",
    98: "3",
    99: "2"
    
}

var X100_START = 0;
var TIMER_X100 = 0;
var x100Time = 0;
var x100Rotate = 0;
var rot_0_X100 = 0;
var x100Plus = 0;
var statusBonusX100 = 0
async function goX100() {
    var preFinishX100 = false;
    X100_START = 0
    statusBonusX100 = 0
    await client.query('UPDATE settings SET status_x100 = ?', [0])
    var intervalX100 = setTimeout(async function wait_x100() {
        const sw = await client.query('SELECT count(*) FROM x100')
        io.sockets.emit('X100_TIME', {
            time: 30,
            bet: 'on'
        })
        if (sw[0]['count(*)'] > 0) {
            if(!preFinishX100) {
                preFinishX100 = true
                startX100(30)

                clearTimeout(intervalX100)
                return
            }
        }else{
            console.log('wait')
            var intervalX100 = setTimeout(wait_x100, 1000);
        }
    }, 1000);

    
}


goX100()



function sumMassivs(massiv, number){
    var new_massiv = []
    for (var i = 0; i <= number; i++) {
     new_massiv = new_massiv.concat(massiv);
 }

 return new_massiv;


}

var x100BonusAvatars = []
var x100Status = 0
function startX100(TIMER_WHEEL){
    console.log('go')
    var TIMER_X100 = TIMER_WHEEL;
    var preFinishX100 = false;


    const cw = setInterval(async () => {
        TIMER_X100 -= 1
        io.sockets.emit('X100_TIME', {
            time: TIMER_X100,
            text: 'Прокрутка через',
            bet: 'on'
        })
        if (TIMER_X100 <= 1) {
            await client.query('UPDATE settings SET status_x100 = ?', [1])
            
        }

        if (TIMER_X100 <= 0 && !preFinishX100) {
            preFinishX100 = true
            await clearInterval(cw)

            

            var colorCoffResultX100 = null

            //// RAN

            io.sockets.emit('X100_TIME', {
                time: 0,
                text: 'Генерируем число...',
                bet: 'off'
            })

            type = 'False'
            while (type == 'False'){
                type = await randOrg('x100')
            }

            
            
            //////////////////////

            const setting = await client.query('SELECT * FROM settings')         


            //////////////////////////////////////

            var rand_key_x100 = rand_keyX100
            var rand_random_x100 = rand_randomX100
            var rand_signature_x100 = rand_signatureX100

            number_x100 = rand_key_x100
            console.log('NUMB '+number_x100)

            colorCoffResultX100 = x100Data[number_x100]
            
            x100Plus = rand(5, 37) / 10
            if(rot_0_X100 == 0){
                rot_0_X100 = 1
                umn = 360
            }else{
                umn = 360 * 8
                rot_0_X100 = 0
            }
            x100Status = 1
            x100Rotate = 360 / 100 * (number_x100) + umn;
            TipeWheel = 'cubic-bezier(0, 0.49, 0, 1)'
            io.sockets.emit('X100_START', { x100Status:1,x100Plus, x100Time: 30,TipeWheel, x100Rotate })

            var finishX100 = 30
            var finisherx100 = false

            BonusUser_ID = setting[0].X100BonusUser_ID;
            BonusAvatar  = setting[0].X100BonusAvatar;

            if(BonusUser_ID != 0){
                statusBonusX100 = 1
                x100BonusAvatars = [];
                const x100Info = await client.query('SELECT * FROM x100')
                x100Info.forEach(async (e) => {
                    img = e.img
                    user_id = e.user_id

                    m = {'user_id': user_id, 'img':img}
                    x100BonusAvatars.push(m)
                    
                })

                lengthX100Avatars = x100BonusAvatars.length
                colvoX100Avatars = (100 / lengthX100Avatars).toFixed(0)

                x100BonusAvatars = sumMassivs(x100BonusAvatars, colvoX100Avatars)
                shuffle(x100BonusAvatars)
                console.log(x100BonusAvatars)
                

                

                x100BonusAvatars[49] = {'user_id': BonusUser_ID, 'img':BonusAvatar}

                io.sockets.emit('X100_START_BONUS', { x100BonusAvatars, BonusUser_ID })
            }
            var FINISH_X100 = setTimeout(async function fin_w_1() {

                finishX100 -= 1
                x100Time = finishX100

                if(finishX100 == 20){
                    if(statusBonusX100 == 1){
                        statusBonusX100 = 2
                    }
                }

                io.sockets.emit('X100_TIME', {
                    time: finishX100,
                    text: 'Новый раунд через',
                    bet: 'off'
                })


                if (finishX100 == 0 && !finisherx100) {
                    finisherx100 = true

                    await clearTimeout(FINISH_X100)                                    

                    var coffNumberX100 = await X100ColorCoff(colorCoffResultX100)                                      

                    var coeff = coffNumberX100


                    await client.query('INSERT INTO x100_history (number,coff, random, signature) VALUES (?,?, ?, ?)', [number_x100,colorCoffResultX100, rand_random_x100, rand_signature_x100])
                    await client.query('UPDATE settings SET win_x100="false", x100WinNumber = ?', [coffNumberX100])

                    console.log('Win wait...')

                    type = 'False'
                    while (type == 'False'){
                        type = 'True'
                        type = await winUserX100()
                    }


                    console.log('Win done...')



                    await client.query('TRUNCATE x100')
                    await client.query('UPDATE x100_anti SET win = 0')
                    await client.query('UPDATE settings SET X100BonusUser_ID = 0, x100WinNumber = 0, X100BonusAvatar = 0')



                    const history = await client.query('SELECT number,id,coff,random,signature FROM x100_history ORDER BY id DESC LIMIT 0,50')




                    io.sockets.emit('X100_FINISH', { history, colorCoffResultX100 })

                    setTimeout(() => io.sockets.emit('X100_CLEAR'), 1000);
                    x100Status = 0
                    setTimeout(goX100, 1000)



                    return
                }


                var FINISH_X100 = setTimeout(fin_w_1, 1000);
            }, 1000);



        }


    }, 1000)


}

// ENG X100

// JACKPOT

var statusJackpot = 0;
var avatarJackpot = [];
var cashHantJackpot = [];
var timerJackpot = 0;
var timerCashHantJackpot = 0;
var plusJackpot = 0;
var timerJackpotAnimate = 0;
function unikumBet(res) {
    var arr = []
    for (let i = 0; i < res.length; i++) {
        if (!arr.find(el => el.user_id == res[i].user_id)) {
            arr.push(res[i])
        }
    }
    return arr
}

function animationFinish() {
    timerJackpotAnimate = 30
    const tt = setInterval(() => {
        timerJackpotAnimate -= 1
        console.log(timerJackpotAnimate)
        if (!timerJackpotAnimate) clearInterval(tt);
        return timerJackpotAnimate
    }, 1000)
}


async function waitJackpot() {
    timerJackpot = 30;
    statusJackpot = 0
    var preFinishJackpot = false;
    WHEEL_START = 0
    await client.query('UPDATE settings SET status_jackpot = ?', [0])
    var intervalJackpot = setTimeout(async function wait_jackpot() {
        const result = await client.query('SELECT * FROM jackpot')
        io.sockets.emit('JACKPOT_TIME', {
            time: 30,
            text: 'Ожидание ставок...',
            bet: 'on',
            wait: 1
        })
        if (await unikumBet(result).length > 1) {
            if(!preFinishJackpot) {
                preFinishJackpot = true
                startJackpot()
                clearTimeout(intervalJackpot)
                return
            }
        }else{
           // console.log('waitJackpot')
           var intervalJackpot = setTimeout(wait_jackpot, 1000);
       }
   }, 1000);

    
}

waitJackpot()

async function cashHant(){
    statusJackpot = 1
    io.sockets.emit('CASHHUNT_START')
    timerCashHantJackpot = 10
    var intervalStartJackpotHant = await setTimeout(async function start_hunt() {
        console.log('HUNT')
        timerCashHantJackpot -= 1
        io.sockets.emit('CASHHUNT_TIME', {
            time: await TIMES(timerCashHantJackpot),
        })

        if (timerCashHantJackpot == 0){
            clearTimeout(intervalStartJackpotHant)
            io.sockets.emit('CASHHUNT_FINISH')
            return
        }else{
            var intervalStartJackpotHant = await setTimeout(start_hunt, 1000);
        }        
    }, 1000);
}

async function cashHuntFinish(){
    await requestify.request(domain+'/cashhuntfinish', {
      method: 'GET'
  })
    .then(async function(response) {
        response = response.body;
        console.log(response)
        return 'True'
    })
    .fail(async function (response) {
        console.log('response Error', response.getCode());
        return 'False';

    });
}

async function startJackpot(){
    var intervalStartJackpot = setTimeout(async function start_jackpot() {
        timerJackpot -= 1
        io.sockets.emit('JACKPOT_TIME', {
            time: await TIMES(timerJackpot),
            bet: 'on',
            wait: 0
        })
        if (timerJackpot <= 3) {
            await client.query('UPDATE settings SET status_jackpot = ?', [1])
            
        }

        if (timerJackpot == 0) {
            clearTimeout(intervalStartJackpot)
            // cashHantJackpot = []
            // statusJackpot = 3
            // for (var i = 0; i <= 64; i++) {
            //     cashHantJackpot.push(rand(1, 7))
            // }

            // await client.query('UPDATE settings SET status_jackpot = ?', [2])
            // io.sockets.emit('CASHHUNT_START', {cashHantJackpot})
            // timerCashHantJackpot = 13

            // coefsHunt = []
            // for (var i = 0; i <= 32; i++) {
            //     r = rand(1, 3)
            //     if (r == 1){
            //         x = 0.5
            //     }else{
            //         x = 1
            //     }
            //     coefsHunt.push(x)
            // }
            // // coefsHunt[0] = 1

            // for (var i = 0; i <= 32; i++) {
            //     coefsHunt.push(rand(2, 11))
            // }

            // shuffle(coefsHunt)
            // coefsHuntS = JSON.stringify(coefsHunt)
            // await client.query('UPDATE settings SET coefsHunt = ?', [coefsHuntS])


            // var intervalStartJackpotHant = await setTimeout(async function start_hunt() {
            //     console.log('HUNT')
            //     timerCashHantJackpot -= 1

                // if (timerCashHantJackpot - 3 < 0){
                //     io.sockets.emit('CASHHUNT_TIME', {
                //         time: 0,
                //     })
                // }else{
                //     io.sockets.emit('CASHHUNT_TIME', {
                //         time: (timerCashHantJackpot - 3),
                //     })
                // }
                

                // if(timerCashHantJackpot == 3){

                //     await client.query('UPDATE settings SET status_jackpot = ?', [1])
                //     const ch = await client.query('SELECT * FROM settings')
                //     coefsHunt = JSON.parse(ch[0].coefsHunt)
                //     io.sockets.emit('CASHHUNT_FINISH', {coefsHunt})

                //     coefsHuntS = JSON.stringify(coefsHunt)
                //     await client.query('UPDATE settings SET coefsHunt = ?', [coefsHuntS])


                //     type = 'False'
                //     while (type == 'False'){
                //         type = await cashHuntFinish()
                //     }





                //     const res = await client.query('SELECT SUM(`bet`) FROM jackpot')
                //     bank = res[0]['SUM(`bet`)']



                //     io.sockets.emit('JACKPOT_BANK', {bank})    

                // }

                if (0 == 0){
                    // clearTimeout(intervalStartJackpotHant)              
                    await client.query('UPDATE settings SET status_jackpot = ?', [3])
                    
                    io.sockets.emit('CASHHUNT_END')        


                    statusJackpot = 2;

                    animationFinish()
                    
                    
                    
                    const avatarki = []
                    const res = await client.query('SELECT * FROM jackpot')
                    var bank = 0
                    const players = []
                    const RESULT_JACKPOT = await unikumBet(res)
                    for (let i = 0; i < RESULT_JACKPOT.length; i++) {
                        const w = await client.query('SELECT SUM(`bet`) FROM jackpot WHERE user_id = ?', [RESULT_JACKPOT[i].user_id])
                        bank += w[0]['SUM(`bet`)']
                        RESULT_JACKPOT[i].bet = w[0]['SUM(`bet`)']
                        players.push(RESULT_JACKPOT[i])
                    }


                    for (let i = 0; i < players.length; i++) {
                        console.log(players.length)
                        for (let s = 0; s < Math.floor(Number(players[i].chance)); s++) {
                            avatarki.push(players[i].img)
                        }
                    }

                    type = 'False'
                    while (type == 'False'){
                        type = await randOrgJackpot()
                    }

                    const setting = await client.query('SELECT * FROM settings')
                    var random = setting[0].jackpot_rand
                    var jackpot_random = setting[0].jackpot_random
                    var jackpot_signature = setting[0].jackpot_signature
                    console.log(jackpot_random)
                    const win = await client.query('SELECT * FROM jackpot WHERE tick_one <= ? AND tick_two >= ?', [random, random])
                    var BANK_KOM = 0
                    var BET_USER = 0
                    var BANK = 0
                    for (let i = 0; i < RESULT_JACKPOT.length; i++) {
                        BANK += RESULT_JACKPOT[i].bet
                        if (RESULT_JACKPOT[i].user_id != win[0].user_id) {
                            BANK_KOM += RESULT_JACKPOT[i].bet
                        } else {
                            BET_USER += RESULT_JACKPOT[i].bet
                        }
                    }
                    const comm = await client.query('SELECT * FROM settings')
                    BANK_KOM *= 1 - (comm[0].comisia_jackpot / 100)
                    BANK_KOM += players.find(el => el.user_id === win[0].user_id).bet
                    avatarmk = await shuffle(avatarki);
                    avatarki[59] = win[0].img

                    avatarJackpot = avatarki
                    jackpot_status = true
                    plusJackpot = rand(5, 30)

                    io.sockets.emit('JACKPOT_ANIMATION_START', { players, avatarJackpot, plusJackpot, timerJackpotAnimate: 30 })

                    PROFIT_J = BANK - BANK_KOM
            // await client.query('UPDATE settings SET profit_jackpot = profit_jackpot + ? ', [PROFIT_J])
            

            setTimeout(async () => {
                await client.query('UPDATE users SET balance = balance + ? WHERE id = ?', [BANK_KOM, win[0].user_id])
                await client.query('INSERT INTO jackpot_history (user_id, login, avatar, bet, win, random, signature) VALUES (?, ?, ?, ?, ?, ?, ?)', [win[0].user_id, win[0].login, win[0].img, BET_USER, BANK, jackpot_random, jackpot_signature])

                await client.query('TRUNCATE jackpot')
                io.sockets.emit('JACKPOT_FINISH', {
                    login: win[0].login,
                    img: win[0].img,
                    bank: BANK_KOM,
                    random: random,
                    bet: BET_USER,
                    percent: win[0].chance
                })
                setTimeout(async(e) => {
                    io.sockets.emit('JACKPOT_NOTIFICATION', {
                        user_id: win[0].user_id,
                        win: BANK_KOM,
                    })
                    await client.query('UPDATE settings SET jackpot_wait = -1')
                    io.sockets.emit('JACKPOT_CLEAR')
                    setTimeout(waitJackpot, 100)
                }, 2000)
            }, 30000)
        }
    //     }else{
    //         var intervalStartJackpotHant = await setTimeout(start_hunt, 1000);
    //     }        
    // }, 1000);







    return
}else{
    var intervalStartJackpot = setTimeout(start_jackpot, 1000);
}

}, 1000);
}
// END JACKPOT

// KENO
var numbersKeno = [];
var timerKeno = 15;
var statusKeno = 0;
var selectNumberKeno = [];
var bonusKeno = {};
async function waitKeno() {
    timerKeno = 15;
    statusKeno = 0
    var preFinishKeno = false;
    await client.query('UPDATE settings SET status_keno = ?', [0])
    var intervalKeno = setTimeout(async function wait_keno() {
        const resultKeno = await client.query('SELECT COUNT(*) FROM keno')
        io.sockets.emit('KENO_TIME', {
            time: 15,
        })
        if (resultKeno[0]['COUNT(*)'] > 0) {
            if(!preFinishKeno) {
                preFinishKeno = true
                startKeno()
                clearTimeout(intervalKeno)
                return
            }
        }else{
            var intervalKeno = setTimeout(wait_keno, 1000);
        }
    }, 1000);

    
}

waitKeno()

async function startTimerKeno() {
    timerKenoAnimate = 4
    const tt_keno = setInterval(async () => {
        timerKenoAnimate -= 1
        if (timerKenoAnimate <= 0){ 
            clearInterval(tt_keno);
        }
        io.sockets.emit('KENO_TIME', {
            time: await TIMES(timerKenoAnimate)
        })
        
    }, 1000)
}

async function startKeno(){
    var intervalStartKeno = setTimeout(async function start_keno() {
        timerKeno -= 1
        io.sockets.emit('KENO_TIME', {
            time: await TIMES(timerKeno)
        })

        if (timerKeno <= 3) {
            await client.query('UPDATE settings SET status_keno = ?', [1])
            
        }

        if (timerKeno <= 0) {
            clearTimeout(intervalStartKeno)
            startTimerKeno()
            const setting = await client.query('SELECT * FROM settings')

            numberBonusKeno = rand(1, 40);
            coeffBonusKeno = rand(2, 6);

            if (setting[0].numberBonusKeno != 0){
                numberBonusKeno = setting[0].numberBonusKeno
            }

            if (setting[0].coeffBonusKeno != 0){
                coeffBonusKeno = setting[0].coeffBonusKeno
            }
            bonusKeno = {'number': numberBonusKeno, 'coeff': coeffBonusKeno}
            await client.query('UPDATE settings SET numberBonusKeno = ?, coeffBonusKeno = ?', [numberBonusKeno, coeffBonusKeno])
            io.sockets.emit('KENO_BONUS', {
                bonusKeno
            })
            console.log(bonusKeno)


            numbersKeno = []   

            
            noGetKeno = setting[0].noGetKeno
            noGetKeno = JSON.parse(noGetKeno) 
            if (noGetKeno.length > 5){
                noGetKeno = noGetKeno.slice(-20)
            }

            youtube_keno = setting[0].youtube_keno
            if (youtube_keno == 1){
                noGetKeno = []
            }

            numbersKeno = JSON.parse(setting[0].keno_numbers)
            if (numbersKeno.length > 0){
                noGetKeno = []
            }

            console.log(noGetKeno)
            while (1 == 1){
                if(numbersKeno.length == 5){
                    break
                }
                randItem = rand(1, 41)
                while (1 == 1){
                    if(numbersKeno.indexOf(randItem) != -1 || noGetKeno.indexOf(randItem) != -1){  
                        randItem = rand(1, 41)
                    }else{
                        break
                    } 
                }
                numbersKeno.push(randItem)
            }

            console.log(numbersKeno)
            console.log(numbersKeno)

            numbersKeno.forEach(async function(item, i, arr) { 
                setTimeout(function(){
                    selectNumberKeno.push(item)
                    io.sockets.emit('KENO_SELECT', {item})
                }, 400 * ++i)
            }); 


            setTimeout(async function(){
                await client.query('UPDATE settings SET keno_numbers = ?', [JSON.stringify(numbersKeno)])

                console.log('Win wait...')

                typeKenoWin = 'False'
                while (typeKenoWin == 'False'){
                    typeKenoWin = await winUserKeno()
                }


                console.log('Win done...')

                setTimeout(async function(){
                    await client.query('UPDATE settings SET numberBonusKeno = ?, coeffBonusKeno = ?, keno_numbers = "[]", noGetKeno = "[]", youtube_keno = 0', [0, 0])

                    await client.query('TRUNCATE keno')
                    selectNumberKeno = []
                    numbersKeno = []
                    bonusKeno = {}
                    io.sockets.emit('KENO_CLEAR')
                    return setTimeout(waitKeno, 1000);
                }, 3000) 
            }, 5000) 
        }else{

            var intervalStartKeno = setTimeout(start_keno, 1000);
        }
    }, 1000);
}




async function winUserKeno(){
    await requestify.request(domain+'/winkeno', {
      method: 'GET'
  })
    .then(async function(response) {
        response = response.body;
        console.log(response)
        return 'True'
    })
    .fail(async function (response) {
        console.log('response Error', response.getCode());
        return "False";

    });
} 

// END KENO


// CRASH

async function waitCrash() {
    timerCrash = 15;
    statusCrash = 0;
    crashBoom = 0
    var preFinishCrash = false;
    await client.query('UPDATE settings SET crash_status = ?', [0])
    startCrash()
    return
}

waitCrash()

var now_iks = 0
var bankCrash = 0
var crashBoom = 0
var winAllCrash = 0
var betAllCrash = 0
var statusCrashGo = 0
var nowIksCrash = 0

var _i = 0;
var _now = 0;
var _data = [];
var _label = [];

function startCrash() {
    var timer_crash = 10
    var preFinishCrash = false;

    var intervalStartCrash = setTimeout(async function start_crash() {
        timer_crash -= 1
        io.sockets.emit('crashTitle', {
            text: '00:' + TIMES(timer_crash)
        })
        if (timer_crash <= 1) {
            io.sockets.emit('crashPrepare')
            await client.query('UPDATE settings SET crash_status = ?', [1])
        }

        if (timer_crash <= 0 && !preFinishCrash) {
            io.sockets.emit('crashGo')
            preFinishCrash = true
            statusCrashGo = 1

            intcrash_main = 0;
            massiv_res = [100, 200, 200, 200, 500, 500, 400, 300,300, 300, 400, 400, 300, 300, 400, 550, 700, 1000, 4000, 20000]
            shuffle(massiv_res);
            var rand_cw = Math.floor(Math.random() * massiv_res.length);
            result_crash = massiv_res[rand_cw];
            result_crash = rand(100, result_crash) / 100;

            var sssss = await client.query('SELECT * FROM settings')

            bankCrash = sssss[0].crash_bank;

            var crash_boom = sssss[0].crash_boom;
            if (crash_boom != 0) {
                result_crash = crash_boom
            }


            start_plus = 0.01
            start_time = 300
            now_iks = 1
            nowIksCrash = 1

            _i = 0;
            _now = 0;
            _data = [];
            _label = [];

            await client.query('UPDATE settings SET crash_status = ?', [3])
            

            start_des = 0


            var off = 0
            var upd = 1

            var gameCrash = {};
            var gameCrashCoeffs1 = [];
            var gameCrashGo = 0
            var IndexCrash = 0

            const crash = await client.query('SELECT * FROM crash ORDER BY auto ASC')
            crash.forEach(function(e, i, arr) {
                if (gameCrash[e.auto] == null){
                    gameCrash[e.auto] = 0
                }
                countCoeff = gameCrash[e.auto]

                gameCrash[e.auto] =  countCoeff + 1
                gameCrashCoeffs1.push(e.auto)
                gameCrashGo = 1
            })

            gameCrashCoeffs = gameCrashCoeffs1.filter(function(item, pos) {
                return gameCrashCoeffs1.indexOf(item) == pos;
            })

            console.log(gameCrash)

            var select_crash_counting = await client.query('SELECT SUM(`bet`) FROM crash WHERE result = 0')
            winAllCrash = select_crash_counting[0]['SUM(`bet`)']
            if(winAllCrash == null){
                winAllCrash = 0
            }
            betAllCrash = winAllCrash
            console.log('Bank: '+bankCrash+' WinAllCrash: '+winAllCrash)

            var settings_crash = await client.query('SELECT * FROM settings')
            var youtube_crash = settings_crash[0].youtube_crash;
            var crash_bank = settings_crash[0].crash_bank;
            var crash_boom = settings_crash[0].crash_boom;
            var auto_crash = settings_crash[0].auto_crash;


            var intervalUpdateCrash = setTimeout(async function crash_upd() {

                var str = String(now_iks.toFixed(2));              


                if (youtube_crash == 0 && auto_crash == 1 && crash_boom == 0) {
                    console.log('Check')
                    if (winAllCrash * now_iks > bankCrash && winAllCrash > 0) {
                        off = 1
                        result_crash = now_iks
                    }
                }

                if (crash_boom != 0) {
                    if (crash_boom <= now_iks + start_plus) {
                        off = 1
                        result_crash = now_iks
                    }
                }

                if (now_iks + start_plus >= result_crash && crash_boom == 0) {
                    off = 1
                    result_crash = now_iks
                }

                if(crashBoom == 1){
                    off = 1
                    result_crash = now_iks
                }

                if(off != 1){
                    io.sockets.emit('crashTitle', {
                        play: 1,
                        text: str,
                        start_time,
                        data: _data,
                        label: _label
                    })
                }


                if (off == 1) {
                    statusCrashGo = 0

                    var sel_crash = await client.query('SELECT user_id, bet, id, auto FROM crash WHERE result = 0 and auto <= ?', [now_iks])

                    var sel_crash_bet = await client.query('SELECT SUM(`bet`) FROM crash WHERE result = 0 and auto <= ?', [now_iks])
                    bets = sel_crash_bet[0]['SUM(`bet`)']

                    var sel_crash_win = await client.query('SELECT SUM(`win`) FROM crash WHERE result = 0 and auto <= ?', [now_iks])
                    wins = sel_crash_win[0]['SUM(`win`)']

                    bankCrash -= wins
                    winAllCrash -= bets

                    console.log('Bank: '+bankCrash+' WinAllCrash: '+winAllCrash)

                    await io.sockets.emit('crashUpdate', {
                        type: '2',
                        publishMassiv: sel_crash,
                    })

                    // await client.query('UPDATE crash SET result = auto * bet  WHERE result = 0 and auto <= ?', [now_iks])

                    sel_crash.forEach(async function(e, i, arr) {
                        // transform: 100px;
                        // await notyUserCrash()
                        

                        crash_userId = e.user_id
                        crash_userBet = e.bet
                        gameId = e.id

                        crash_userCoeff = e.auto
                        crash_userWin = crash_userCoeff * crash_userBet        
                        
                        await client.query('UPDATE crash SET result = ?  WHERE id = ?', [crash_userCoeff, gameId])

                        var user_bd = await client.query('SELECT balance, demo_balance, type_balance FROM users WHERE id = ?', [crash_userId])

                        type_balance = user_bd[0]['type_balance']

                        if(type_balance == 0){
                            balanceLast = user_bd[0]['balance']
                            balanceNew = crash_userWin + user_bd[0]['balance']
                            await client.query('UPDATE users SET balance = ?  WHERE id = ?', [balanceNew, crash_userId])
                        }else{
                            balanceLast = user_bd[0]['demo_balance']
                            balanceNew = crash_userWin + user_bd[0]['demo_balance']
                            await client.query('UPDATE users SET demo_balance = ?  WHERE id = ?', [balanceNew, crash_userId])
                        }
                        

                        io.sockets.emit('crashNoty', {
                            balanceLast, balanceNew,
                            win: crash_userWin,
                            user_id: crash_userId
                        })

                    })

                    result_crash = now_iks
                    
                    var str = String(result_crash.toFixed(2));
                    io.sockets.emit('crashTitle', {
                        text: str,
                        play: 1,
                        start_time: 20,
                        data: _data,
                        label: _label
                    })

                    await client.query('UPDATE settings SET crash_status = 2, crash_boom = 0, crash_result = 0, youtube_crash = 0')



                    io.sockets.emit('crashDead', {text: str})

                    console.log('Win wait...')

                    typeCrashWin = 'False'
                    
                    typeCrashWin = await winUserCrash()
                    
                    console.log('Win done...') 

                    var selectcrash = await client.query('SELECT * FROM crash')
                    var arr_win = []
                    var arr_lose = []
                    selectcrash.forEach(function(e, i, arr) {

                        if (e.result != 0) {
                            bet_user = e.bet
                            win_user = bet_user * e.result
                            game_user = e.user_id
                            arr_win.push({
                                user_id: e.user_id,
                                win_user
                            })
                        } else {
                            arr_lose.push({
                                id: e.id
                            })
                        }
                    })

                    if (youtube_crash == 0 && auto_crash == 1 && crash_boom == 0) {
                        await client.query('UPDATE settings SET crash_bank = ?', [bankCrash])
                    }else{
                        await client.query('UPDATE settings SET crash_bank = crash_bank - ?', [betAllCrash])
                    }

                    await client.query('TRUNCATE crash')
                    var str = String(result_crash.toFixed(2));
                    await client.query('INSERT INTO `crash_history` (`num`) VALUES (?)', [result_crash])
                    const s = await client.query('SELECT * FROM crash_history order by id desc LIMIT 0,7')
                    now_iks = 0

                    io.sockets.emit('crashFinish', {
                        s,
                        arr_win,
                        arr_lose
                    })


                    setTimeout(() => {
                        io.sockets.emit('crashClear')
                    }, 4000)
                    setTimeout(waitCrash, 5000)
                    return

                } else {



                    if(gameCrashGo == 1){
                        if(gameCrashCoeffs[IndexCrash] <= now_iks){
                            IndexCrash += 1
                            upd = 0
                            var sel_crash = await client.query('SELECT user_id, bet, id, auto FROM crash WHERE result = 0 and auto <= ?', [now_iks])
                            
                            var sel_crash_bet = await client.query('SELECT SUM(`bet`) FROM crash WHERE result = 0 and auto <= ?', [now_iks])
                            bets = sel_crash_bet[0]['SUM(`bet`)']

                            var sel_crash_win = await client.query('SELECT SUM(`win`) FROM crash WHERE result = 0 and auto <= ?', [now_iks])
                            wins = sel_crash_win[0]['SUM(`win`)']

                            bankCrash -= wins
                            winAllCrash -= bets

                            console.log('Bank: '+bankCrash+' WinAllCrash: '+winAllCrash)

                            await io.sockets.emit('crashUpdate', {
                                type: '2',
                                publishMassiv: sel_crash
                            })



                            sel_crash.forEach(async function(e, i, arr) {

                                crash_userId = e.user_id
                                crash_userBet = e.bet
                                gameId = e.id

                                crash_userCoeff = e.auto
                                crash_userWin = crash_userCoeff * crash_userBet        

                                await client.query('UPDATE crash SET result = ?  WHERE id = ?', [crash_userCoeff, gameId])

                                var user_bd = await client.query('SELECT balance, demo_balance, type_balance FROM users WHERE id = ?', [crash_userId])

                                type_balance = user_bd[0]['type_balance']

                                if(type_balance == 0){
                                    balanceLast = user_bd[0]['balance']
                                    balanceNew = crash_userWin + user_bd[0]['balance']
                                    await client.query('UPDATE users SET balance = ?  WHERE id = ?', [balanceNew, crash_userId])
                                }else{
                                    balanceLast = user_bd[0]['demo_balance']
                                    balanceNew = crash_userWin + user_bd[0]['demo_balance']
                                    await client.query('UPDATE users SET demo_balance = ?  WHERE id = ?', [balanceNew, crash_userId])
                                }
                                

                                await io.sockets.emit('crashNoty', {
                                    balanceLast, balanceNew,
                                    win: crash_userWin,
                                    user_id: crash_userId
                                })

                                // await crashPublish(gameId, crash_userWin, crash_userId, crash_userCoeff)

                                
                                // bankCrash -= crash_userWin
                                // winAllCrash -= crash_userBet


                            })

                        }
                    }





                    _i++;
                    _now = parseFloat(Math.pow(Math.E, 0.00006*_i*1000/20));
                    now_iks = _now

                    _data.push(_now);
                    _label.push(_i);
                    
                    // console.log(now_iks)
                    
                    // start_des += 1
                    // if (start_des == 10 && start_time > 20) {
                    //     start_des = 0;
                    //     start_plus += 0.005
                    //     start_time -= 0.07
                    // }
                }


                var intervalUpdateCrash = setTimeout(crash_upd, 50);

            }, 50);
} else {
    var intervalStartCrash = setTimeout(start_crash, 1000);
}
}, 1000);


}

async function notyUserCrash() {
    await io.sockets.emit('crashUpdate', {
        type: '2',
        publishMassiv: sel_crash
    })
}

async function crashPublish(gameId, crash_userWin, crash_userId, crash_userCoeff){
    await io.sockets.emit('crashUpdate', {
        type: '1',
        game_id: gameId,
        win_user: crash_userWin,
        user_id: crash_userId,
        coeff: crash_userCoeff
    })
}


async function winUserCrash() {


    await requestify.request(domain + '/wincrash', {
        method: 'GET'
    })
    .then(async function(response) {
        response = response.body;
        console.log(response)
        return 'True'
    })
    .fail(async function(response) {
        console.log('response Error', response.getCode());
        return "False";

    });
}
// END CRASH

// START BOOM

var dataBoom = [
'1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1',
'2', '2', '2', '2', '2', '2', '2', '2', '2', '2', 
'5', '5', '5', '5', '5',
'dice',
'lucky',
'boom',
'power', 'power', 'power',
'bust', 'bust' 
]

var statusBoom = 0
var blocksBoom = stretchArray(['wait'], 36)
var timeBoom = 30
var bonusBoom = {}
var dicesBoom = [0, 0]

async function waitBoom() {
    timeBoom = 30;
    statusBoom = 0 // WAIT
    var preFinishBoom = false;

    await client.query('UPDATE settings SET status_boom = ?', [0])
    var intervalBoom = setTimeout(async function wait_boom() {
        const resultBoom = await client.query('SELECT COUNT(*) FROM boom_city')
        io.sockets.emit('BOOM_TIME', {
            time: 30,
        })
        if (resultBoom[0]['COUNT(*)'] >= 0) {
            if(!preFinishBoom) {
                preFinishBoom = true
                startBoom()
                clearTimeout(intervalBoom)
                return
            }
        }else{
            var intervalBoom = setTimeout(wait_boom, 1000);
        }
    }, 1000);

    
}

waitBoom()

async function startBoom(){
    var intervalStartBoom = setTimeout(async function start_boom() {
        timeBoom -= 1
        io.sockets.emit('BOOM_TIME', {
            time: timeBoom
        })

        if (timeBoom <= 3) {
            await client.query('UPDATE settings SET status_boom = ?', [1])
        }

        if (timeBoom <= 0) {
            clearTimeout(intervalStartBoom)
            const setting = await client.query('SELECT * FROM settings')

            statusBoom = 1 // DICE
            dicesBoom = [1, 1]
            blocksBoom = dataBoom
            shuffle(blocksBoom)
            
            io.sockets.emit('BOOM_START_DICE', {
                dicesBoom, blocksBoom
            })
        }else{

            var intervalStartBoom = setTimeout(start_boom, 1000);
        }
    }, 1000);
}

// END BOOM

function stretchArray(arr, limit) {
  if (!arr.length || limit < arr.length) {
    throw new Error('Не удалось растянуть массив.');
}

  // Целое число, на которое будет размножен каждый элемент.
  const integer = Math.floor(limit / arr.length);

  // a % b - остаток от деления.
  // По единичке будем накидывать на каждый элемент.
  // Кому досталось, тому досталось, как `крошки` со стола.
  let crumbs = limit % arr.length;

  const newArr = Array.from(arr, function(item, index) {
    // Сколько раз нужно размножить элемент массива.
    const repeater = integer + (crumbs > 0 ? 1 : 0);

    // Уменьшаем количество `крошек`.
    crumbs--;

    // Размножаем элемент массива и возвращаем.
    return Array(repeater).fill(item);
});
  
  // [[1, 1], [2, 2]] => [1, 1, 2, 2]
  return [].concat(...newArr);

  // Можно с помощью `flat`:
  // return newArr.flat();
}


var nowTimeChat = 0;

var dateObj = new Date();
dateObj.setDate(dateObj.getDate() + 1);

var month = dateObj.getUTCMonth() + 1; //months from 1-12
var day = dateObj.getUTCDate();
var year = dateObj.getUTCFullYear();
var newdate = year + "/" + month + "/" + day;

timesChat = [newdate+' 11:00', newdate+' 12:00']
            timesChat_2 = ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00']
var timeChat = timesChat[nowTimeChat % 2]
var diff = Math.abs(new Date() - new Date(timeChat.replace(/-/g,'/')));

var chatHour = Math.floor((diff / (1000 * 60 * 60)) % 24);
var chatMinute = Math.floor((diff / (1000 * 60)) % 60);
var chatSecond = Math.floor((diff / 1000) % 60);




async function chatPromo(){

    var intervalchat = setTimeout(async function waitPromo() {
        if(chatSecond <= 0){
            chatSecond = 60
            chatMinute -= 1
            if(chatMinute < 0){
                chatMinute = 59
                chatSecond = 60
                chatHour -= 1
                if(chatHour < 0){
                    chatHour = 0
                }
            }
        }
        
        chatSecond -= 1
        if(chatSecond <= 0){
            chatSecond = 0
        }

        hour =  await TIMES(chatHour)
        minute = await TIMES(chatMinute)
        second = await TIMES(chatSecond)



        io.sockets.emit('CHAT_TIME', {chatHour: hour,  chatMinute: minute, chatSecond: second  })

        if(chatHour <= 0 && chatMinute <= 0 && chatSecond <= 0){
            await promoPublish(timesChat_2[nowTimeChat % 2])

            nowTimeChat += 1
            if(nowTimeChat % 2 == 0){
                dateObj = new Date();
            }else{
                dateObj = new Date();
                dateObj.setDate(dateObj.getDate() + 1);
            }
            
            month = dateObj.getUTCMonth() + 1; //months from 1-12
            day = dateObj.getUTCDate();
            year = dateObj.getUTCFullYear();
            newdate = year + "/" + month + "/" + day;

            timesChat = [newdate+' 15:00', newdate+' 16:00']
            timesChat_2 = ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00']

            timeChat = timesChat[nowTimeChat % 2]
            diff = Math.abs(new Date() - new Date(timeChat.replace(/-/g,'/')));

            chatHour = Math.floor((diff / (1000 * 60 * 60)) % 24);
            chatMinute = Math.floor((diff / (1000 * 60)) % 60);
            chatSecond = Math.floor((diff / 1000) % 60);


            
            return chatPromo()
        }else{
            var intervalchat = setTimeout(waitPromo, 1000);
        }
        
        
        
    }, 1000);
}


async function promoPublish(time){
    requestify.request(domain+'/chat/promo/publish', {
        method: 'POST'
    }).then((e) => console.log(e))
}


function startPromoTimer() {
	var now = Math.round(new Date().getTime()/1000);
	var end = Math.round(new Date().getTime()/1000) + 1800;
	var seconds = end - now;

	let startTimer = setInterval(() => {
		if(seconds == 0) {
			clearInterval(startTimer);
			sendPromo();
			startPromoTimer(); // запускаем таймер заново
			return;
		}
		seconds--;
		io.sockets.emit('CHAT_TIME', {
			chatHour: (((seconds - seconds % 3600) / 3600) % 60 < 10 ? '0' + ((seconds - seconds % 3600) / 3600) % 60 : ((seconds - seconds % 3600) / 3600) % 60),
			chatMinute: (((seconds - seconds % 60) / 60) % 60 < 10 ? '0' + ((seconds - seconds % 60) / 60) % 60 : ((seconds - seconds % 60) / 60) % 60),
			chatSecond: (seconds % 60 < 10 ? '0' + seconds % 60 : seconds % 60)
		});
	}, 1000)
}

function sendPromo() {
	requestify.post(domain+'/chat/promo/publish')
	.then(function(res) {

	}, function(res) {
		log.error('[CHAT] Ошибка при генерации промокода!');
		setTimeout(sendPromo, 1000);
	});
}

startPromoTimer()