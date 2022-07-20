<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Simple CMS" />
    <meta name="author" content="Gheorghii" />

    <title>Leaves</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/css/bootstrap.min.css" integrity="sha512-T584yQ/tdRR5QwOpfvDfVQUidzfgc2339Lc8uBDtcp/wYu80d7jwBgAxbyMh0a9YM9F8N3tdErpFI8iaGx6x5g==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- jQuery (Cloudflare CDN) -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap Bundle JS (Cloudflare CDN) -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.min.js" integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function postRequest(title, parent_id) {
            let data = {
                title: title
            }
            if (parseInt(parent_id)) {
                data.parent_id = parent_id;
            }
            $.post("/api/leaves/create",
                data,
                function(data, status){
                    if (status === 'success') {
                        //document.location.reload();
                        const ul = `<ul class="list-group" data-id="${data.leave_id}"><li class="list-group-item" data-id="${data.leave_id}">${title} <button type="button" data-id="${data.leave_id}" id="btn-create-${data.leave_id}" class="btn btn-primary" data-toggle="modal" data-target="#modal">+</button> <button type="button" data-id="${data.leave_id}" id="btn-delete-${data.leave_id}" class="btn btn-primary" data-toggle="modal" data-target="#modal2">-</button></li></ul>`;
                        if (parent_id) {
                            $('#modal').modal('hide');
                            $(`[id="btn-delete-${parent_id}"]`).after(ul);
                        } else {
                            $('#create-root-button').hide();
                            $('body').append(ul);
                        }

                        $(`[id="btn-create-${data.leave_id}"]`).click(function(event) {
                            $('#leave-name').val('');
                            $('#parent_id').val(event.target.getAttribute('data-id'));
                        });

                        $(`[id="btn-delete-${data.leave_id}"]`).click(function(event) {
                            $('#timer').text(20);
                            $('#leave_id').val(event.target.getAttribute('data-id'));
                            timeinterval = setInterval(updateClock, 1000);
                        });
                    }
            });
        }

        function updateClock()
        {
            if ($('#modal2').is(":hidden")) {
                window.clearInterval(timeinterval);
                return ;
            }
            const time = parseInt($('#timer').text()) - 1;
            $('#timer').text(time)

            if (time < 1) {
                window.clearInterval(timeinterval);
                $('#modal2').modal('hide');
            }
        }
        let timerinterval='';
        document.addEventListener('DOMContentLoaded', function() {
            $('[id*="btn-create-"]').click(function(event) {
                $('#leave-name').val('');
                $('#parent_id').val(event.target.getAttribute('data-id'));
            });


            $('[id*="btn-delete-"]').click(function(event) {
                $('#timer').text(20);
                $('#leave_id').val(event.target.getAttribute('data-id'));
                timeinterval = setInterval(updateClock, 1000);
            });

            $('#modal-button-delete').click(function(event) {
                const leaveId = $('#leave_id').val();
                $.ajax({
                    url: "/api/leave/" + leaveId,
                    type: 'DELETE',
                    success: function(result) {
                        if (!result.has_leaves) {
                            if ($('#create-root-button').is(":hidden")) {
                                $('#create-root-button').show();
                            } else {
                                $('body').append('<button type="button" id="create-root-button" class="btn btn-primary">create root</button>');
                                $('#create-root-button').click(function(event) {
                                    postRequest('root', 0);
                                });
                            }
                        }
                        //document.location.reload();
                        $('#modal2').modal('hide');
                        $('ul[data-id="'+ leaveId +'"]').remove();
                    }
                });
            });

            $('#modal-button-create').click(function(event) {
                const leaveName = $('#leave-name').val();
                const parentId = $('#parent_id').val();
                postRequest(leaveName, parentId);
            });

            $('#create-root-button').click(function(event) {
                postRequest('root', 0);
            });

            $( "#leave-name" ).change(function() {
                if ($( "#leave-name" ).val()) {
                    $('#modal-button-create').prop( "disabled", false );
                } else {
                    $('#modal-button-create').prop( "disabled", true );
                }
            });

        });
    </script>
</head>
<body>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal">Создание нового узла</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="leave-name">Название узла:</label>
                <input id="leave-name" type="text" name="name">
                <input type="hidden" id="parent_id" name="parent_id" value="0">
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-button-create" class="btn btn-primary" disabled>Создать</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal2">Удаление узла</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title" id="modal2">Вы хотите удалить этот узел?</h5>
                <input type="hidden" id="leave_id" name="leave_id" value="0">
            </div>
            <div class="modal-footer">
                <span id="timer">20</span>
                <button type="button" id="modal-button-delete" class="btn btn-primary">Да</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Нет</button>
            </div>
        </div>
    </div>
</div>

@if ($leaves->count())
    @include('inc.recursive', ['leaves'=> $leaves])
@else
    <button type="button" id="create-root-button" class="btn btn-primary">
        create root
    </button>
@endif

</body>
</html>
