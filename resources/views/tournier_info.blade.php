@php
$t = \App\Tourniers::where('id', $_GET['id'])->first();

$start = date("d.m H:i", $t->start);
$end = date("d.m H:i", $t->end);
@endphp
<div class="wrapper">
    <div class="tournier">
        <div class="tournier__page-title d-flex justify-center align-center">
            <div class="tournier__page-t-box d-flex flex-column align-center justify-center">
                <h4>{{$t->name}}</h4>
                <b>{{$start}} - {{$end}}</b>
                <svg class="icon tournier__page-t-ico"><use xlink:href="images/symbols.svg?v=6#tournier"></use></svg>
            </div>
        </div>
        <div class="tournier__list d-flex flex-column">
            <div class="tournier__page d-flex flex-column" id="activity">
                <a class="tournier__item tournier__item--shoot">
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
                    <div class="tournier__item-center d-flex flex-column">
                        <p>{{$t->description}}</p>
                        <button onclick="location.href='{{$t->class}}'" class="btn btn--blue is-ripples flare d-flex align-center has-ripple"><span>Перейти к режиму</span></button>
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
            </div>
            <div class="tournier__separate"></div>
            <div class="history">
                <table>
                    <thead>
                        <tr>
                            <td>Место</td>
                            <td>Участник</td>
                            <td>Общий выигрыш</td>
                            <td>Приз</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $limit = $t->places + 20;
                        $tournier_table = \App\TournierTable::where('tournier_id', $t->id)->orderBy('scores', 'desc')->limit($limit)->get();
                        $count_t = 0;
                        $prizes = json_decode($t->prizes);
                        @endphp
                        @foreach($tournier_table as $tt)

                        <tr>
                            <td>
                                #{{($count_t + 1)}}
                            </td>
                            <td>
                                <div class="history__user d-flex align-center justify-center">
                                    <div class="history__user-avatar" style="background: url({{$tt->avatar}}) no-repeat center center / cover;"></div>
                                    <span>{{$tt->name}}</span>
                                </div>
                            </td>
                            <td>
                                {{$tt->scores}}
                            </td>
                            <td>
                                <div class="history__sum d-flex align-center justify-center">
                                    <span>@if($count_t + 1 <= $t->places) {{$prizes[$count_t]}} @else - @endif</span>
                                        <svg class="icon money"><use xlink:href="images/symbols.svg#coins"></use></svg>
                                    </div>
                                </td>
                            </tr>

                            @php
                            $count_t += 1;
                            @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>