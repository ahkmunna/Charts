@extends('charts::default')

@include('charts::_partials.container.div')

<script type="text/javascript">
$(function() {
    var {{ $model->id }} = new JustGage({
        id: "{{ $model->id }}",
        value: $model->values ? $model->values[0] : '0';

        @if(count($model->values) >= 2 and $model->values[1] <= $model->values[0])
            $min = $model->values[1];
            min: $min,
        @else
            $min = 0;
        @endif

        @if(count($model->values) >= 3 and $model->values[2] >= $model->values[0])
            $max = $model->values[2];
            max: $max,
        @else
            $max = 100;
        @endif

        donut: true,
        gaugeWidthScale: 0.6,
        counter: true,
        @if($model->title)
            title:  "{{ $model->title }}",
        @endif
        label: "{{ $model->element_label }}",
        hideInnerShadow: true
    })

    setInterval(function() {
        $.getJSON( "{{ $model->url }}", function( jdata ) {
            {{ $model->id }}.refresh(jdata["{{ $model->value_name }}"])
        })
    }, {{ $model->interval }})
});
</script>

