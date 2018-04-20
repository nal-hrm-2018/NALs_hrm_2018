<div id="myModal" class="modal fade">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Search form</h4>
            </div>
            {!! Form::open(
            ['url' =>route('search-process'),
            'class' => 'form-inline',
            'method'=>'GET'
            ]) !!}
            @include('employee._form_search_process')

            <div class="modal-footer center">
                <button type="reset" class="btn btn-default"><span class="fa fa-refresh"></span> RESET</button>
                <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> SEARCH</button>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>