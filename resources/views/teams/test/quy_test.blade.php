@extends('admin.template')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Edit team
            </h1>
            <ol class="breadcrumb">
                <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/team">Teams</a></li>
                <li class="active">Add team</li>
            </ol>
        </section>
        <section class="content">
            <div class="form-group">
                <select class="form-control" id="multi_form" name="employees[]">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </section>
        {{--<section class="content">
            <select multiple="multiple" id="my-select" name="my-select[]">
                <option value='elem_1'>elem 1</option>
                <option value='elem_2'>elem 2</option>
                <option value='elem_3'>elem 3</option>
                <option value='elem_4'>elem 4</option>
            </select>
        </section>--}}

    </div>

    <script type="text/javascript"
            src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="{!! asset('admin/templates/js/my_script/jquery.multi-select.js') !!}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript">
        $('#multi_form').multiSelect()
        $('.searchable').multiSelect({
            selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='try \"12\"'>",
            selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='try \"4\"'>",
            afterInit: function(ms){
                var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function(e){
                        if (e.which === 40){
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function(e){
                        if (e.which == 40){
                            that.$selectionUl.focus();
                            return false;
                        }
                    });
            },
            afterSelect: function(){
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function(){
                this.qs1.cache();
                this.qs2.cache();
            }
        });
    </script>
@endsection