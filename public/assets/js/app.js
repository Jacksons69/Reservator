const app = {

    modalId : 0,
    
    init: () => {
        app.listenAddShow();
        app.datePicker();
        app.listenFormNewShow();
        app.listenDeleteShow();
        app.listenEditShow();
        app.listenModalNewBooking();
        app.listenFormNewBooking();
        app.listenSeeBooking();
    },

    listenAddShow: () => {
        $('#add-show').click(function() {
            $('#new-show').removeClass('hidden').addClass('show');
        })

        $('#hide-show-form').on('click', () => {
            $('#new-show').removeClass('show').addClass('hidden');
        });
    },

    listenFormNewShow: () => {

        $('#new-show').on('submit', '#new-show-form', evt => {
            evt.preventDefault();
            const formDatas = new FormData(event.target);

            $.ajax({
                method: 'POST',
                url: 'show/add',
                data: formDatas,
                dataType: "json",
                processData: false,
                contentType: false,

                success : response =>{
                    $('#show-list').load('#show-list .table, #show-list #add-show', () => {
                        app.listenAddShow();
                        app.listenEditShow();
                    });
                    $('#new-show-form').find("input[type=text]").val('');
                },
                error: response => {
                  alert(response+'Merci de réessayer');
                }
            });
        })
    },

    listenDeleteShow: () => {

        $('#show-list').on('click', '.delete-show', evt => {
            const showId = {
                'id': evt.target.getAttribute('name')
            };
            $.ajax({
                method: 'POST',
                url: 'show/delete',
                data: showId,
                dataType: 'json',
                success : response =>{
                    $('#show-list').load('#show-list .table, #show-list #add-show', () => {
                        app.listenAddShow();
                        app.listenEditShow();
                    });
                },
                error: response => {
                    alert(response+'Merci de réessayer');
                }
            })
        })
    },

    listenEditShow: () => {
        app.showEditForm();
        app.hideEditForm();

        $('#show-list').on('click', '.valid-edit-show', evt => {
            const id = evt.target.getAttribute('name');
            app.treatEditForm(id);
        })

    },

    treatEditForm: id => {
    
        $('#show-list').on('submit', '.edit-show-form-'+id, evt =>{
            evt.preventDefault();
            const formDatas = new FormData(event.target);

            $.ajax({
                method: 'post',
                url: 'show/edit',
                data: formDatas,
                dataType: "json",
                processData: false,
                contentType: false,
                success : response =>{
                    $('#show-list').load('#show-list .table, #show-list #add-show', () => {
                        app.listenAddShow();
                        app.listenEditShow();
                        app.datePicker();
                        app.hideEditForm();
                    });
                },
                error: response => {
                    alert(response+'Merci de réessayer');
                }
            })
        })
       
    },

    showEditForm: () => {
        $('.edit-show').on('click', evt => {
            const id = evt.target.getAttribute('name');
            $('.edit-show-form-'+id).removeClass('hidden').addClass('show');
            $('.show-data-'+id).removeClass('show').addClass('hidden');
        })
    },

    hideEditForm: () => {
        $('.cancel-edit-show').on('click', evt => {
            const id = evt.target.getAttribute('name');
            $('.edit-show-form-'+id).removeClass('show').addClass('hidden');
            $('.show-data-'+id).removeClass('hidden').addClass('show');
        })
    },

    listenModalNewBooking: () => {
        $('.add-booking').on('click', evt =>{
            app.modalId = evt.target.getAttribute('name');
        })
    },

    listenFormNewBooking: () => {
        $('#form-new-booking').on('submit', evt => {
            evt.preventDefault();
       
            $.ajax({
                method: 'post',
                url: 'booking/add',
                data: $('#form-new-booking').serialize() + "&id=" + app.modalId,
    
                success : response =>{
                    window.location.reload();
                },
                error: response => {
                    alert(response+'Merci de réessayer');
                }
            })
        })

    },

    listenSeeBooking: () => {
        $('.see-booking').on('click', evt => {

            const datas = {id : evt.target.getAttribute('name')}
            
            $.ajax({
                method: 'post',
                data: datas,
                url: 'booking/show',
    
                success : response =>{
        
                    const listName = JSON.parse(response);

                    $('.people-name li').remove();
                    $('.empty-booking').remove();
                    if (listName.names.length > 0) {
         
                        listName.names.map((name, index) =>{
                            $('.people-name').append('<li>'+name+' <i class="fas fa-trash delete-booking" name='+listName.id[index]+'></i></li>');
                        })
                        app.listenDeleteBooking();

                    } else {
                        $('#booking-details').append('<p class="alert alert-danger empty-booking">Aucune réservation pour ce spectacle </p>');
                    }

                    jQuery('#booking-details').modal('show');
                },
                error: response => {
                    alert(response+'Merci de réessayer');
                }
            })
        })
    },

    listenDeleteBooking: () => {
        $('.delete-booking').on('click', evt => {
            const nameId = {
                'id': evt.target.getAttribute('name')
            };
            $.ajax({
                method: 'POST',
                url: 'booking/delete',
                data: nameId,
                dataType: 'json',
                success : response =>{
                    window.location.reload();
                },
                error: response => {
                    alert(response+'Merci de réessayer');
                }
            })
        })
    },

    datePicker: () => {
        $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
    }
}
app.init();
