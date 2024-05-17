@php 
$settings = App\Models\Utility::settings();
$campaigntypes = explode(',',$settings['campaign_type']);
@endphp
<style>
    .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    #pagebox2 .list-group-item {
        background-color: #f0f0f0;
    }
    .scrolldiv{
        max-height: 200px;
        overflow-y: auto;
        padding: 0px;
    }
</style>

    <!-- <form method="POST" id="checkboxForm"> -->
        <div class="row">
        <div class="col-md-4">
                <h6>Category</h6>
                <div class="form-group">
                    <select name="category" id="category" class="form-select">
                        @foreach($campaigntypes as $campaign)
                        <option value="{{$campaign}}" class="form-select">{{$campaign}}</option>
                        @endforeach
                    </select>
               
                </div>
            </div>
            <div class="col-md-4">
                <h6>List</h6>
                <div class="form-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search By List name">
                    <div class="selectpagebox scrolldiv" id="pagebox1">
                        <ul class="list-group">
                            @foreach($leadsuser as $user)
                                <li class="list-group-item">
                                    {{ucfirst($user->name)}}
                                    <input type="checkbox" name="users[]" class="pages" value="{{$user->email}}" style="float: right;">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h6>Selected Users</h6>
                <div class="form-group">
                    <input type="text" name="search" id="searchSelected" class="form-control">
                    <div class="selectpagebox" id="pagebox2">
                        <ul class="list-group">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="submit" value="Save" id="saveuser" class="btn btn-success">
            <button type="button" class="btn  btn-light"
            data-bs-dismiss="modal">Close</button>
        </div>
<script>
    $('#pagebox1').on('change', 'input[type="checkbox"]', function() {
    var listItemText = $(this).closest('li').text();
    var listItemValue = $(this).val();

    if ($(this).prop('checked')) {
        // If the checkbox is checked, add the item to the second div
        $('#pagebox2 ul').append('<li class="list-group-item" data-value="' + listItemValue + '">' + listItemText + 
                                    '<i class="fas fa-times float-right remove-icon"></i>' + 
                                '</li>');
    } else {
        $('#pagebox2 ul li[data-value="' + listItemValue + '"]').remove();
    }
});
    $('#pagebox2').on('click', '.remove-icon', function() {
        var removedValue = $(this).closest('li').data('value');
        $('#pagebox1 input[type="checkbox"][value="' + removedValue + '"]').prop('checked', false);
        $(this).closest('li').remove();
    });
   
    $('#saveuser').click(function() {
            var selectedValues = $('#pagebox1 input[type="checkbox"]:checked').map(function() {
                return $(this).val();
            }).get();
            console.log(selectedValues);
            var selectedCount = selectedValues.length;
            localStorage.setItem('selectedValues', JSON.stringify(selectedValues));
            setTimeout(function(){
               location.reload();
            }, 1000);
        });
    </script>
