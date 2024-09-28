@extends('layout.app')
@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{count($docs) && $docs[0]->historySalary ? $docs[0]->historySalary->name : "Bảng lương"}}</h3></br>
            </div>
            <div id="registration-form">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter table-bordered text-nowrap table-primary">
                            <thead class="bg-primary text-white">
                            {{--{{dd($docs[0]->key)}}--}}
                                @if(count($docs) && count($docs[0]->key))
                                    <tr>
                                        @forelse($docs[0]->key as $item)
                                            <th>{{$item}}</th>
                                            @empty
                                            @endforelse
                                        {{--@for($i = 0; $i<= $end; $i++)--}}
                                            {{--<th class="text-center">{{$i < 10 ? '0'.$i :$i}}</th>--}}
                                        {{--@endfor--}}
                                    </tr>
                                @endif
                            </thead>
                            <tbody>
                            @php
                                $data = [];
                                if(count($docs) && count($docs[0]->key)){
                                    foreach ($docs[0]->key as $key=>$item){

                                        $data[$key] = 0;
                                    }
                                }
                            @endphp
                            @forelse($docs as $key=> $item)
                                <tr>
                                    @forelse($item->value as $key=> $item)
                                        @php
                                            if(is_integer($item)){
                                               $data[$key] += $item;}
                                        @endphp
                                        <td>{{is_integer($item) ? number_format($item): $item}}</td>
                                    @empty
                                    @endforelse
                                </tr>
                            @empty
                                <td></td>
                            @endforelse


                            @if(count($docs) && count($docs[0]->key))
                                <tr>
                                    @forelse($docs[0]->key as $key=> $item)
                                        <td class="bold">{{$data[$key] > 0 ? number_format($data[$key]) : ''}}</td>
                                    @empty
                                    @endforelse
                                    {{--@for($i = 0; $i<= $end; $i++)--}}
                                    {{--<th class="text-center">{{$i < 10 ? '0'.$i :$i}}</th>--}}
                                    {{--@endfor--}}
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
            <!-- table-responsive -->
        </div>
    </div>
@endsection
@section('_script')
    <script>
    </script>
@endsection
