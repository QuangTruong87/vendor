@if(!empty($items))
<?php
$withs = [
    'order' => '10%',
    'col'   => '10%'
];

$counter = 1;
?>
<caption>
    @if(count($items) == 1)
    {!! trans($plang_admin.'.descriptions.counter', ['number' => 1]) !!}
    @else
    {!! trans($plang_admin.'.descriptions.counters', ['number' => count($items)]) !!}
    @endif
</caption>

<table class="table table-hover">

    <thead>
        <tr style="height: 50px;">

            <!--ORDER-->
            <th style='width:{{ $withs['order'] }}'>
                {{ trans($plang_admin.'.columns.order') }}
            </th>

            <!-- COLUMNS -->
            <?php $item = $items[0]; ?>
            @foreach($item as $key => $value)
                <th style='width:{{ $withs['col'] }}'>
                    {!! $key !!}
                </th>
            @endforeach

        </tr>

    </thead>

    <tbody>
        @foreach($items as $item)
        <tr>
            <!--ORDER-->
            <td> <?php echo $counter;  $counter++; ?> </td>

            <!--COLUMN-->
            @foreach($item as $key => $value)
                <td> {!! $value !!} </td>
            @endforeach

        </tr>
        @endforeach

    </tbody>

</table>
<div class="paginator">

</div>
@else
<!--SEARCH RESULT MESSAGE-->
<span class="text-warning">
    <h5>
        {{ trans($plang_admin.'.descriptions.not-found') }}
    </h5>
</span>
<!--/SEARCH RESULT MESSAGE-->
@endif

@section('footer_scripts')
@parent
{!! HTML::script('packages/foostart/js/form-table.js')  !!}
@stop