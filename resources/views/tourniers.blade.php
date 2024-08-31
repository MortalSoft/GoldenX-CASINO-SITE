 <div class="wrapper">
                <div style="margin-top: 35px" class="tournier">
                    <div class="tournier__page-title d-flex justify-center align-center">
                        <div class="tournier__page-t-box d-flex flex-column align-center justify-center">
                            <h4>Турниры</h4>
                            <b>Показаны активные турниры</b>
                            <svg class="icon tournier__page-t-ico"><use xlink:href="images/symbols.svg?v=6#tournier"></use></svg>
                        </div>
                    </div>
                    <div class="tournier__list d-flex flex-column"> 
                        <div class="tournier__page d-flex flex-column" id="activity">
                            @php
                                $tourniers = \App\Tourniers::where('status', 1)->get();
                            @endphp
                            @foreach($tourniers as $t)
                                @php
                                    $end = date("d.m H:i", $t->end);
                                @endphp
                                <a  href="tournier_info?id={{$t->id}}"  class="tournier__item tournier__item--shoot flare">
                                    <div class="tournier__item-top d-flex align-center">
                                        <div class="tournier__item-label d-flex align-center">
                                            <svg class="icon"><use xlink:href="images/symbols.svg?v=6#tournier"></use></svg>
                                            <b>{{$t->name}}</b>
                                        </div>
                                        <div class="tournier__item-label tournier__item-label--orange d-flex align-center">
                                            <b>{{$t->prize}}</b>
                                            <svg class="icon small"><use xlink:href="images/symbols.svg#coins"></use></svg>
                                        </div>
                                    </div>
                                    <div class="tournier__item-center">

                                    </div>
                                    <div class="tournier__item-bottom">
                                        <div class="tournier__stat d-flex flex-column align-center">
                                            <h3>Призовой фонд</h3>
                                            <b>{{$t->prize}}</b>
                                        </div>
                                        <div class="tournier__stat d-flex flex-column align-center">
                                            <h3>Призовых мест</h3>
                                            <b>{{$t->places}}</b>
                                        </div>
                                        <div class="tournier__stat d-flex flex-column align-center">
                                            <h3>Игра</h3>
                                            <b>{{$t->game}}</b>
                                        </div>
                                        <div class="tournier__stat d-flex flex-column align-center">
                                            <h3>Конец</h3>
                                            <b>{{$end}}</b>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            
                        </div>
                        <div class="tournier__separate"></div>
                    </div>
                </div>
            </div>