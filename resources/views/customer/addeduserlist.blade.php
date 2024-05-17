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
<div class="modal-body">
    <div class="row">
        <div class="col-md-4">
            <h6>Category</h6>
            <div class="form-group">
                <input type="text" name="searchcategory"id="searchcategory"class="form-control"placeholder ="Search By Category">
                <div class="scrolldiv"id="category">
                    <ul class="list-group categories">
                        @foreach($campaigntypes as $campaign)
                        <li class="list-group-item">{{ucfirst($campaign)}}<input type="checkbox" name="type[]" value="{{$campaign}}" style="  float: right;"></li>
                        @endforeach
                    </ul>
                </div>
            
            </div>    
        </div>
        <div class="col-md-4">
            <h6>All Users</h6>
            <div class="form-group">
                <input type="text" name="search" id="search" class="form-control"placeholder ="Search By List name">
                <div id="checkboxContainer" class="scrolldiv">
                    <ul class="list-group"></ul>
                </div>
            </div>    
        </div>
        <div class="col-md-4">
            <h6>Selected Users</h6>
            <div class="form-group" >
                <input type="text" name="search" class="form-control "id ="selected_users" placeholder ="Search">
                <div class="selectpagebox scrolldiv" id="pagebox2">
                    <ul class="list-group">
                    </ul>
                </div>
            
            </div>    
        </div>
    </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
        <input type="submit" value="Save"id="saveuser" class="btn  btn-success" > 
    </div>
<script>
    $('.categories input[type="checkbox"]').change(function () {
        var checkedValues = $('input[type="checkbox"]:checked').map(function () {
                return $(this).val() !== 'on' ? $(this).val() : null;
            }).get().filter(Boolean);
        $.ajax({
            url: "{{ route('campaign_categories') }}",
            type: 'POST',
            data: {
                "types": checkedValues,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                $('#checkboxContainer ul').empty();
                $('#pagebox2 ul').empty();
                for (var i = 0; i < data.length; i++) {
                    var innerArray = data[i];
                    for (var j = 0; j < innerArray.length; j++) {
                        var user = innerArray[j];
                        var list = `<li class = "list-group-item">${user.name}(${user.category})<input type ="checkbox" name="users[]" value ="${user.email}"class="form-check pages"></li>`
                        $('#checkboxContainer ul').append(list);
                    }
                }
            }
        });
    });
    $('#checkboxContainer').on('change', 'input[type="checkbox"]', function() {
        var listItemText = $(this).closest('li').text();
        var listItemValue = $(this).val();
        if ($(this).prop('checked')) {
            $('#pagebox2 ul').append('<li class="list-group-item" data-value="' + listItemValue + '">' + listItemText + 
                                        '<i class="fas fa-times float-right remove-icon"></i>' + 
                                    '</li>');
        } else {
            $('#pagebox2 ul li[data-value="' + listItemValue + '"]').remove();
        }
    });
    $('#pagebox2').on('click', '.remove-icon', function() {
        var removedValue = $(this).closest('li').data('value');
        $('#checkboxContainer input[type="checkbox"][value="' + removedValue + '"]').prop('checked', false);
        $(this).closest('li').remove();
    });
    $('#search').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        $('#checkboxContainer ul li').each(function() {
        var listItemText = $(this).text().toLowerCase();
        if (listItemText.includes(searchTerm)) {
            $(this).show();
        } else {
            $(this).hide();
        }
        });
    });
    $('#searchcategory').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        $('#category ul li').each(function() {
        var listItemText = $(this).text().toLowerCase();
        // console.log(listItemText);
        if (listItemText.includes(searchTerm)) {
            $(this).show();
        } else {
            $(this).hide();
        }
        });
    });
    $('#selected_users').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        $('#pagebox2 ul li').each(function() {
        var listItemText = $(this).text().toLowerCase();
        if (listItemText.includes(searchTerm)) {
            $(this).show();
        } else {
            $(this).hide();
        }
        });
    });
    $('#saveuser').click(function() {
            var selectedValues = $('#checkboxContainer input[type="checkbox"]:checked').map(function() {
                return $(this).val();
            }).get();
            var selectedCount = selectedValues.length;
            localStorage.setItem('selectedValues', JSON.stringify(selectedValues));
            setTimeout(function(){
               location.reload();
            }, 1000);
        });
</script>
