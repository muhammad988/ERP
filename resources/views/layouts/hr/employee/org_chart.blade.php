@extends('layouts.app')
@section('style')
    @include('layouts.include.style.style_list')
    <script src="https://balkangraph.com/js/latest/OrgChart.js"></script>

@stop
@section('content')
    <div class="row">
        <div id="tree"></div>
    </div>

@stop
@section('script')
    @include('layouts.include.script.script_list')
    <script>

        window.onload = function () {
            let data ={!! $users !!};
            var chart = new OrgChart(document.getElementById("tree"), {
                template: "polina",
                layout: OrgChart.mixed,
                nodeBinding: {
                    field_0: "name",
                    field_1: "title",
                    img_0: "img"
                },
                nodes: data.data
            });
            chart.draw();


        }

    </script>
@stop
