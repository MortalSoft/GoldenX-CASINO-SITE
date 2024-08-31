/**
 * @required: 
 */


var JS_FIREWORKS = JS_FIREWORKS || {};

/**
 * @usage:
 *      firework = JS_FIREWORKS.Fireworks({
 *          id : 'fireworks-canvas',
 *          hue : 120,
 *          particleCount : 50,
 *          delay : 30,
 *          minDelay : 30,
 *          maxDelay : 90,
 *          boundaries : {
 *              top: 50,
 *              bottom: 240,
 *              left: 50,
 *              right: 590
 *          },
 *          fireworkSpeed : 2,
 *          fireworkAcceleration : 1.05,
 *          particleFriction : .95,
 *          particleGravity : 1.5
 *      });
 *      firework.start();
 *      firework.stop();
 */
JS_FIREWORKS.Fireworks = function (options) {

    'use strict';

    if (!(this instanceof JS_FIREWORKS.Fireworks)) {
        return new JS_FIREWORKS.Fireworks(options);
    }

    options = options || {};

    var _self   = this,
        _NS     = JS_FIREWORKS,
        _Class  = _NS.Fireworks,
        _proto  = _Class.prototype,
        _canvas = document.getElementById(options.id || 'fireworks-canvas'),
        _ctx    = _canvas.getContext ? _canvas.getContext('2d') : null,
        _width  = _canvas.width,
        _height = _canvas.height,
        _hue        = options.hue || 120,
        _isRunning  = false,
        _fireworks  = [],
        _particles  = [],
        _particleCount = options.particleCount || 50,
        _tick       = 0,
        _delay      = options.delay || 30,
        _minDelay   = options.minDelay || 30,
        _maxDelay   = options.maxDelay || 90,
        _boundaries = options.boundaries || {
            top    : 50,
            bottom : _height * .5,
            left   : 50,
            right  : _width - 50
        },
        _loop         = _NS.getRenderLoop(),
        _randRange    = _NS.randomRange,
        _randIntRange = _NS.randomIntRange,
        _Firework     = _NS.Firework,
        _Particle     = _NS.Particle;


    _Class.settings = {
        fireworkSpeed : options.fireworkSpeed || 2,
        fireworkAcceleration : options.fireworkAcceleration || 1.05,
        particleFriction : options.particleFriction || .95,
        particleGravity : options.particleGravity || 1.5
    };

    _Class.version = '1.0.2';


    _self.start = function () {
        _isRunning = true;
        _fireworks = [];
        _particles = [];
        _render();
    };

    _self.stop = function () {
        _isRunning = false;
        _self.clear();
    };

    _self.isRunning = function () {
        return _isRunning;
    };

    _self.clear = function () {
        if (!_ctx) {
            return;
        }
        _ctx.globalCompositeOperation = 'source-over';
        _ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
        _ctx.fillRect(0, 0, _width, _height);
    };



    var _render = function () {
        if (!_ctx || !_isRunning) {
            return;
        }
        var tmp, count;
        _loop(_render);
        _hue += 0.5;
        _ctx.globalCompositeOperation = 'destination-out';
        _ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
        _ctx.fillRect(0, 0, _width, _height);
        _ctx.globalCompositeOperation = 'lighter';
        tmp = _fireworks.length;
        // render fireworks
        while (tmp--) {
            _fireworks[tmp].draw();
            _fireworks[tmp].update( function (x, y, hue) {
                count = _particleCount;
                while (count--) {
                    _particles.push(_Particle(x, y, _ctx, hue));
                }
                _fireworks.splice(tmp, 1);
            });
        }
        // render particles
        tmp = _particles.length;
        while (tmp--) {
            _particles[tmp].draw();
            _particles[tmp].update( function () {
                _particles.splice(tmp, 1);
            });
        }
        // spawn firework
        if (_tick === _delay) {
            _fireworks.push(_Firework(
                _width * .5,
                _height,
                _randIntRange(_boundaries.left, _boundaries.right),
                _randIntRange(_boundaries.top, _boundaries.bottom),
                _ctx,
                _hue
            ));
            _delay = _randIntRange(_minDelay, _maxDelay);
            _tick = 0;
        }
        _tick++;
    };


    return _self;

};

/**
 * 
 */
JS_FIREWORKS.Firework = function (x1, y1, x2, y2, context, hue) {

    'use strict';

    if (!(this instanceof JS_FIREWORKS.Firework)) {
        return new JS_FIREWORKS.Firework(x1, y1, x2, y2, context, hue);
    }

    var _self     = this,
        _NS       = JS_FIREWORKS,
        _Class    = _NS.Firework,
        _proto    = _Class.prototype,
        _settings = JS_FIREWORKS.Fireworks.settings,
        _x   = x1,
        _y   = y1,
        _sx  = x1,
        _sy  = y1,
        _dx  = x2,
        _dy  = y2,
        _ctx = context,
        _totalDistance   = 0,
        _currentDistance = 0,
        _coordinates     = [],
        _coordinateCount = 3,
        _angle           = 0,
        _speed           = _settings.fireworkSpeed,
        _acceleration    = _settings.fireworkAcceleration,
        _hue             = hue,
        _brightness      = 0,
        _randIntRange = _NS.randomIntRange,
        _distance     = _NS.distance,
        _sin          = Math.sin,
        _cos          = Math.cos;


    _self.update = function (callback) {
        _coordinates.pop();
        _coordinates.unshift([_x, _y]);
        _speed *= _acceleration;
        var vx = _cos(_angle) * _speed,
            vy = _sin(_angle) * _speed;
        _currentDistance = _distance(_sx, _sy, _x + vx, _y + vy);
        if (_currentDistance >= _totalDistance) {
            callback(_dx, _dy, _hue);
        } else {
            _x += vx;
            _y += vy;
        }
    };

    _self.draw = function () {
        var last = _coordinates.length - 1;
        _ctx.beginPath();
        _ctx.moveTo(_coordinates[last][0], _coordinates[last][1]);
        _ctx.lineTo(_x, _y);
        _ctx.strokeStyle = 'hsl(' + _hue + ', 100%, ' + _brightness + '%)';
        _ctx.stroke();
    };


    ( function () {
        _totalDistance = _distance(_sx, _sy, _dx, _dy);
        while (_coordinateCount--) {
            _coordinates.push([_x, _y]);
        }
        _angle = Math.atan2(_dy - _sy, _dx - _sx);
        _brightness = _randIntRange(50, 70);
    })();

    return _self;

};

/**
 * 
 */
JS_FIREWORKS.Particle = function (x, y, context, hue) {

    'use strict';

    if (!(this instanceof JS_FIREWORKS.Particle)) {
        return new JS_FIREWORKS.Particle(x, y, context, hue);
    }

    var _self     = this,
        _NS       = JS_FIREWORKS,
        _Class    = _NS.Particle,
        _proto    = _Class.prototype,
        _settings = JS_FIREWORKS.Fireworks.settings,
        _x        = x,
        _y        = y,
        _ctx      = context,
        _coordinates     = [],
        _coordinateCount = 5,
        _angle    = 0,
        _speed    = 0,
        _friction   = _settings.particleFriction,
        _gravity    = _settings.particleGravity,
        _hue        = hue,
        _brightness = 0,
        _alpha      = 1,
        _decay      = 0,
        _randRange    = _NS.randomRange,
        _randIntRange = _NS.randomIntRange,
        _2PI          = Math.PI * 2,
        _sin          = Math.sin,
        _cos          = Math.cos;

    _self.update = function (callback) {
        _coordinates.pop();
        _coordinates.unshift([_x, _y]);
        _speed *= _friction;
        _x += _cos(_angle) * _speed;
        _y += _sin(_angle) * _speed + _gravity;
        _alpha -= _decay;
        if (_alpha <= _decay) {
            callback();
        }
    };

    _self.draw = function () {
        var last = _coordinates.length - 1;
        _ctx.beginPath();
        _ctx.moveTo(_coordinates[last][0], _coordinates[last][1]);
        _ctx.lineTo(_x, _y);
        _ctx.strokeStyle = 'hsla(' + _hue + ', 100%, ' + _brightness + '%, ' + _alpha + ')';
        _ctx.stroke();
    };


    ( function () {
        while (_coordinateCount--) {
            _coordinates.push([_x, _y ]);
        }
        _angle = _randRange(0, _2PI);
        _speed = _randIntRange(1, 10);
        _hue   = _randIntRange(_hue - 20, _hue + 20);
        _brightness = _randIntRange(50, 80);
        _decay = _randRange(.015, .03);
    })();

    return _self;

};

/**
 * 
 */
JS_FIREWORKS.randomRange = function (min, max) {
    return (Math.random() * ( max - min ) + min);
};

/**
 * 
 */
JS_FIREWORKS.randomIntRange = function (min, max) {
    return JS_FIREWORKS.randomRange(min, max)|0;
};

/**
 * 
 */
JS_FIREWORKS.distance = function (x1, y1, x2, y2) {
    var pow = Math.pow;
    return Math.sqrt(pow(x1 - x2, 2) + pow(y1 - y2, 2));
};

/**
 * 
 */
JS_FIREWORKS.getRenderLoop = function () {
    return (
        window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame || 
        window.mozRequestAnimationFrame || 
        window.oRequestAnimationFrame || 
        window.msRequestAnimationFrame || 
        function (callback) { 
            return window.setTimeout(callback, 1000 / 60); 
        }
    );
};
