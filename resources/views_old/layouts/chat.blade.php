 
<div class="col-chat-lg ">
    <div style="height: 100%;display: grid;position: relative;">
        <div class="chat">
            <div class="panel_chat">
                <div class="top_chat d-comp">
                    <span class="title_chat">ЧАТ</span> 
                    <span class="circle_online"></span>
                    <span class="online"></span>
                </div>

                <div class="top_chat d-mob">
                    <div style="width:100%"><span class="circle_online_mob"></span>
                        <span class="title_chat" style="font-size: 18px;line-height: 22px;color: #1A2547;">ЧАТ</span> </div>

                        <div style="width:100%;text-align: right;">
                            <svg class="icon_mob_online"><use xlink:href="img/main/symbols.svg?v=45#user"></use></svg>
                            <span class="online online_mob" ></span>
                        </div>
                        
                        
                    </div>
                    <div class="messages @auth auth @endauth element">

                    </div>
                   @auth
                    <div class="bottom_chat" style="position:relative;">
                        <input type="" onkeydown="if(event.keyCode==13){ disable(this);sendMess(this); }" class="input_chat" placeholder="Сообщение..." autocomplete="off" name="" id="messageChat">
                        <div class="chat_send" > 

                        <svg width="18" onclick="disable(this);sendMess(this)" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.7825 0.217449C17.6813 0.116704 17.5534 0.046952 17.4139 0.0163941C17.2744 -0.0141638 17.1291 -0.00425713 16.995 0.0449493L0.495001 6.04495C0.352702 6.09892 0.230191 6.19491 0.143739 6.32016C0.0572872 6.44542 0.0109863 6.59401 0.0109863 6.7462C0.0109863 6.89839 0.0572872 7.04698 0.143739 7.17223C0.230191 7.29749 0.352702 7.39348 0.495001 7.44745L6.9375 10.0199L11.6925 5.24995L12.75 6.30745L7.9725 11.0849L10.5525 17.5275C10.6081 17.667 10.7043 17.7866 10.8286 17.8709C10.953 17.9551 11.0998 18.0001 11.25 17.9999C11.4016 17.9968 11.5486 17.9479 11.6718 17.8595C11.795 17.7711 11.8885 17.6475 11.94 17.5049L17.94 1.00495C17.9911 0.872257 18.0034 0.727772 17.9755 0.588342C17.9476 0.448912 17.8807 0.320282 17.7825 0.217449Z" />
                        </svg>

                        <svg version="1.1" id="Layer_1"  width="18" height="18" onclick="open_panel_stickers()" style="margin-left: 5px;"    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                       viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                       
                            <path d="M264.157,0H256C114.842,0,0,114.842,0,256s114.842,256,256,256s256-114.842,256-256v-8.157L264.157,0z M445.972,237.513
                            c-56.308-1.762-98.861-16.712-126.817-44.667c-27.955-27.955-42.904-70.51-44.666-126.815L445.972,237.513z M256,472.615
                            c-119.442,0-216.615-97.174-216.615-216.615c0-112.413,86.079-205.085,195.78-215.604
                            c-2.527,79.869,16.307,140.464,56.141,180.299c37.481,37.481,93.314,56.384,166.316,56.382c4.586,0,9.261-0.096,13.984-0.247
                            C461.088,386.534,368.414,472.615,256,472.615z" fill="#7981BA"/>
                        
                    
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" onclick="open_panel_smiles()" style="margin-left: 7px;"  width="18" height="18" viewBox="0 0 512 512" class="TextArea_textarea__side__attach__icon__1BKOh"><circle cx="184" cy="232" r="32" fill="#7981BA"></circle><path d="M256.05 384c-45.42 0-83.62-29.53-95.71-69.83a8 8 0 017.82-10.17h175.69a8 8 0 017.82 10.17c-11.99 40.3-50.2 69.83-95.62 69.83z" fill="#7981BA"></path><circle cx="328" cy="232" r="32" fill="#7981BA"></circle><circle cx="256" cy="256" r="232" fill="none" stroke="#7981BA" stroke-miterlimit="10" stroke-width="32"></circle></svg>

                    </div>
                    <div class="panel_smiles">
                        <div class="itemSmile" onclick="addSmileInChat(':smile:')"><img src="img/emoji/smile.png" alt=':smile:'></div>
                        <div class="itemSmile" onclick="addSmileInChat(':hooray:')"><img src="img/emoji/hooray.png" alt=':hooray:'></div>
                        <div class="itemSmile" onclick="addSmileInChat(':cool:')"><img src="img/emoji/cool.png" alt=':cool:'></div>
                        <div class="itemSmile" onclick="addSmileInChat(':cry:')"><img src="img/emoji/cry.png" alt=':cry:'></div>
                        <div class="itemSmile" onclick="addSmileInChat(':sad:')"><img src="img/emoji/sad.png" alt=':sad:'></div>
                        <div class="itemSmile" onclick="addSmileInChat(':laugh:')"><img src="img/emoji/laugh.png" alt=':laugh:'></div>
                        <div class="itemSmile" onclick="addSmileInChat(':interesting:')"><img src="img/emoji/interesting.png" alt=':interesting:'></div>
                        <div class="itemSmile" onclick="addSmileInChat(':eh:')"><img src="img/emoji/eh.png" alt=':eh:'></div>
                        <div class="itemSmile" onclick="addSmileInChat(':money:')"><img src="img/emoji/money.png" alt=':money:'></div>
                        <div class="itemSmile" onclick="addSmileInChat(':robot:')"><img src="img/emoji/robot.png" alt=':robot:'></div>
                        <div class="itemSmile" onclick="addSmileInChat(':angry:')"><img src="img/emoji/angry.png" alt=':angry:'></div>
                        <div class="itemSmile" onclick="addSmileInChat(':tualet:')"><img src="img/emoji/tualet.png" alt=':tualet:'></div>

                        
                    </div>

                    <div class="panel_stickers element"> 
                        <div class="itemSticker" onclick="sendSticker('maxone1')"><img src="img/stickers/maxone1.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('maxone2')"><img src="img/stickers/maxone2.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('maxone3')"><img src="img/stickers/maxone3.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('maxone4')"><img src="img/stickers/maxone4.jpg"></div>

                        <div class="itemSticker" onclick="sendSticker('bomj1')"><img src="img/stickers/bomj1.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('bomj2')"><img src="img/stickers/bomj2.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('bomj3')"><img src="img/stickers/bomj3.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('bomj4')"><img src="img/stickers/bomj4.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('bomj5')"><img src="img/stickers/bomj5.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('bomj6')"><img src="img/stickers/bomj6.jpg"></div>

                        <div class="itemSticker" onclick="sendSticker('vlados1')"><img src="img/stickers/vlados1.jpg"></div>

                        <div class="itemSticker" onclick="sendSticker('monopoly1')"><img src="img/stickers/monopoly1.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('monopoly2')"><img src="img/stickers/monopoly2.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('monopoly3')"><img src="img/stickers/monopoly3.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('monopoly4')"><img src="img/stickers/monopoly4.jpg"></div>

                        <div class="itemSticker" onclick="sendSticker('admin')"><img src="img/stickers/admin.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('stick1')"><img src="img/stickers/stick1.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('stick2')"><img src="img/stickers/stick2.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('stick3')"><img src="img/stickers/stick3.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('stick4')"><img src="img/stickers/stick4.jpg"></div>
                        <div class="itemSticker" onclick="sendSticker('stick5')"><img src="img/stickers/stick5.jpg"></div>

                    </div> 
                </div>
                <style type="text/css">
                .chat_send{
                    right: 20px;
                }
            </style>
            @endauth
         <!--    <div class="bottom_chat">
                <input type="" onkeydown="if(event.keyCode==13){ disable(this);sendMess(this); }" class="input_chat" placeholder="Сообщение..." name="" id="messageChat">
                <div class="chat_send" onclick="disable(this);sendMess(this)"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.7825 0.217449C17.6813 0.116704 17.5534 0.046952 17.4139 0.0163941C17.2744 -0.0141638 17.1291 -0.00425713 16.995 0.0449493L0.495001 6.04495C0.352702 6.09892 0.230191 6.19491 0.143739 6.32016C0.0572872 6.44542 0.0109863 6.59401 0.0109863 6.7462C0.0109863 6.89839 0.0572872 7.04698 0.143739 7.17223C0.230191 7.29749 0.352702 7.39348 0.495001 7.44745L6.9375 10.0199L11.6925 5.24995L12.75 6.30745L7.9725 11.0849L10.5525 17.5275C10.6081 17.667 10.7043 17.7866 10.8286 17.8709C10.953 17.9551 11.0998 18.0001 11.25 17.9999C11.4016 17.9968 11.5486 17.9479 11.6718 17.8595C11.795 17.7711 11.8885 17.6475 11.94 17.5049L17.94 1.00495C17.9911 0.872257 18.0034 0.727772 17.9755 0.588342C17.9476 0.448912 17.8807 0.320282 17.7825 0.217449Z" />
                </svg>
            </div>
        </div> -->
        
    </div>
</div>
</div>

</div> 


<script type="text/javascript">

</script>