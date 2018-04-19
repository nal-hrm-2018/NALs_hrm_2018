<table class="table table-bordered">
    <tbody>
    <tr>

        <td>
            <p>start</p>
        </td>
        <td>
            {{ Form::date('start_date', '',
            ['class' => 'form-control',
            'id' => 'start_date', 'autofocus' => true,
            'style'=>'width:100%'
            ]) }}
        </td>
    </tr>
    <tr>

        <td>
            <p>end</p>
        </td>
        <td>
            {{ Form::date('end_date', '',
            ['class' => 'form-control',
            'id' => 'end_date','autofocus' => true,
            'style'=>'width:100%'
            ]) }}
        </td>
    </tr>
    <tr>

        <td>
            <p>project_status</p>
        </td>
        <td>
            {{ Form::text('project_status', '',
            ['class' => 'form-control',
            'id' => 'project_status','autofocus' => true,
            'style'=>'width:100%'
            ]) }}
        </td>
    </tr>
    <tr>
        <td>
            <p>project_name</p>
        </td>
        <td>
            {{ Form::text('project_name', '',
            ['class' => 'form-control',
            'id' => 'project_name','autofocus' => true,
            'style'=>'width:100%'
            ]) }}
        </td>
    </tr>
    <tr>
        <td>
            <p>role</p>
        </td>
        <td>
            {{ Form::text('role', '',
            ['class' => 'form-control',
            'id' => 'role','autofocus' => true,
            'style'=>'width:100%'
            ]) }}
        </td>
    </tr>
    </tbody>
</table>