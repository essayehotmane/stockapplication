@extends('voyager::master')
@section('css')
    <link rel="stylesheet" type="text/css" href={{asset('vendor/datatables/media/css/dataTables.bootstrap.css')}}>
    <link rel="stylesheet" type="text/css"
          href={{asset('vendor/datatables/extensions/Editor/css/dataTables.editor.css')}}>
    <link rel="stylesheet" type="text/css"
          href={{asset('vendor/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <style>
        .error {
            color: #F00;
            background-color: #FFF;
        }
    </style>
@endsection
@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="tel-repeater">Vente</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <form class="row" id="form" method="post" action="{{route('store_ventes')}}">
                        {{csrf_field()}}
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label for="class_id">Client<span class="text-danger"> * </span>: </label>
                                <button type="button" id="btn_client_click"
                                        class="btn btn-primary save"><i class="voyager-plus"></i>
                                </button>
                                <select class="js-example-basic-multiple form-control select2 select2client"
                                        name="uclients"
                                        id="uclients" required="required">
                                    <option value="" disabled selected>Choisir le Client</option>
                                    @foreach($clients as $fo)
                                        <option value="{{$fo->id}}">{{$fo->nom_complet}}</option>
                                    @endforeach

                                </select>


                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label for="class_id">Date Vente<span class="text-danger"> * </span>: </label>
                                <button type="button"
                                        class="btn btn-primary save" style="visibility: hidden"><i
                                            class="voyager-plus"></i>
                                </button>
                                <input type="date" name="date_vente" required="required" class="form-control">


                            </div>
                        </div>
                        <input type="number" value="0" id="cpt_error">
                        <div class="col-md-12 repeater">
                            <div data-repeater-list="outer-list">
                                <div data-repeater-item>
                                    <div class="card">
                                        <div class="card-header">

                                            <h4 class="card-title" id="tel-repeater">Produit<input
                                                        data-repeater-delete type="button" class="btn btn-warning"
                                                        value="Supprimer" style="margin-left: 20px;"/></h4>
                                            <a class="heading-elements-toggle"><i
                                                        class="icon-ellipsis font-medium-3"></i></a>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="row">

                                                    <div class="form-group col-md-5 mb-2">
                                                        <select class="js-example-basic-multiple form-control select2 select2produit"
                                                                name="uproduits"
                                                                id="uproduits" required="required">
                                                            <option value="" disabled selected>Choisir Produit</option>
                                                            @foreach($produits as $po)
                                                                <option value="{{$po->id}}">{{$po->nom}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-5 mb-2">
                                                        <input type="text"
                                                               class="form-control allownumericwithdecimal qte_stock_change"
                                                               placeholder="Quantité"
                                                               name="quantite" required="required">
                                                        <span class="error"></span>
                                                    </div>
                                                    <div class="form-group col-md-2 mb-2">
                                                        <input type="text" class="form-control allownumericwithdecimal"
                                                               placeholder="Prix"
                                                               name="prix" required="required">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" data-repeater-create class="btn btn-primary" id="repeater-button">
                                <i class="icon-plus4"></i> Ajouter autre produit
                            </button>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-success save pull-left" id="btn_valider">Valider
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>

        <!-- Debut Modal -->
        <div class="modal fade create-clients" id="modal-create-clients" style="display: none;">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter Client</h4>
                    </div>

                    <div class="page-content edit-add container-fluid">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="panel panel-bordered">
                                    <!-- form start -->
                                    <form role="form"
                                          class="form-edit-add"
                                          id="form-create-clients"
                                          action="{{route('voyager.clients.store')}}"
                                          method="POST" enctype="multipart/form-data">
                                        <!-- PUT Method if we are editing -->


                                        <!-- CSRF TOKEN -->
                                        {{ csrf_field() }}

                                        <div class="panel-body">

                                            @if (count($errors) > 0)
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                        @endif

                                        <!-- Adding / Editing -->
                                            <div class="form-group  col-md-12 " id="id-div-clients">

                                                <label class="control-label" for="name">Nom Complet</label>
                                                <input type="text" class="form-control" name="nom_complet"
                                                       placeholder="Nom Complet" required="required">
                                                <input name="_tagging" type="hidden">


                                            </div>


                                        </div><!-- panel-body -->

                                        <div class="panel-footer">

                                            <button type="submit" id="button-create-clients"
                                                    class="btn btn-primary button-submit"
                                                    data-loading-text="{{trans('general.loading')}}">
                                                <span class="fa fa-save"></span> &nbsp;Enregistrer
                                            </button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade modal-danger" id="confirm_delete_modal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;
                                    </button>
                                    <h4 class="modal-title"><i
                                                class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}
                                    </h4>
                                </div>

                                <div class="modal-body">
                                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span
                                                class="confirm_delete_name"></span>'</h4>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                                    <button type="button" class="btn btn-danger"
                                            id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Modal -->


        @stop
        @section('javascript')
            <script src={{asset('vendor/repeater/jquery.repeater.js')}}></script>
            <script src={{asset('vendor/sweetalert2/sweetalert2.all.min.js')}}></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
            <script src="{{asset('vendor/axios/axios.min.js')}}"></script>
            <script>
                window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

                /**
                 * Next we will register the CSRF Token as a common header with Axios so that
                 * all outgoing HTTP requests automatically have it attached. This is just
                 * a simple convenience so we don't have to attach every token manually.
                 */

                let token = document.head.querySelector('meta[name="csrf-token"]');

                if (token) {
                    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
                } else {
                    console.error('CSRF token not found!');
                }
            </script>

            <script type="text/javascript">


                $(document).ready(function () {


                    $(".allownumericwithdecimal").on("keypress keyup blur", function (event) {
                        //this.value = this.value.replace(/[^0-9\.]/g,'');
                        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));

                        if ((event.which != 46 || $(this).val().indexOf('.') == -1) && (event.which < 48 || event.which > 57)) {
                            event.preventDefault();
                        }

                    });
                    $('.repeater').repeater({
                        // (Required if there is a nested repeater)
                        // Specify the configuration of the nested repeaters.
                        // Nested configuration follows the same format as the base configuration,
                        // supporting options "defaultValues", "show", "hide", etc.
                        // Nested repeaters additionally require a "selector" field.
                        defaultValues: {
                            //'quantite': "0"

                        },
                        isFirstItemUndeletable: true,
                        initEmpty: false,

                        show: function () {
                            $(this).slideDown();
                            $('.select2-container').remove();
                            $('.select2produit').select2({
                                placeholder: "Choisir Produits",
                                allowClear: true
                            });
                            $('.select2client').select2({
                                placeholder: "Choisir fournisseur",
                                allowClear: true
                            });
                            $('.select2-container').css('width', '100%');
                            $(".allownumericwithdecimal").on("keypress keyup blur", function (event) {
                                //this.value = this.value.replace(/[^0-9\.]/g,'');
                                $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
                                if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                                    event.preventDefault();
                                }
                            });


                        }, hide: function (remove) {

                            Swal.fire({
                                title: 'Tu es sure?',
                                text: "Vous ne pourrez pas revenir sur cela!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Oui, supprimez-le!'
                            }).then((result) => {
                                if (result.value) {
                                    $(this).slideUp(remove);
                                    Swal.fire(
                                        'Effacé!',
                                        'Votre ligne a été supprimé.',
                                        'success'
                                    )
                                }
                            })
                        },
                        repeaters: [{
                            //isFirstItemUndeletable: true,
                            // (Required)
                            // Specify the jQuery selector for this nested repeater

                            //selector: '.inner-repeater'
                        }]
                    });
                });
                $(document).ready(function () {

                    $('.select2client').select2({
                        placeholder: "Choisir client",
                        allowClear: true
                    });
                    $('.select2produit').select2({
                        placeholder: "Choisir Produits",
                        allowClear: true
                    });
                    $('#btn_client_click').click(function () {
                        $('.create-clients#modal-create-clients').modal('show');
                    });
                    $('#button-create-clients').click(function (e) {


                        //$('.create-clients#button-create-clients').button('reset');

                        //$('.create-clients#span-loading').remove();
                        //$('.create-clients#modal-create-clients').modal('hide');
                        $("#form-create-clients").validate({
                            rules: {
                                nom_complet: {
                                    required: true
                                }
                            },
                            messages: {
                                nom_complet: {
                                    required: "Veuillez remplir le nom"
                                }
                            },
                            submitHandler: function (form, event) {
                                event.preventDefault();

                                $('.create-clients#modal-create-clients .modal-header').before('<span id="span-loading" style="position: absolute; height: 100%; width: 100%; z-index: 99; background: #6da252; opacity: 0.4;"><i class="fa fa-spinner fa-spin" style="font-size: 16em !important;margin-left: 35%;margin-top: 8%;"></i></span>');
                                $.ajax({
                                    url: '{{url("/admin/clients")}}',
                                    type: 'POST',
                                    datatype: 'JSON',
                                    data: $(".create-clients #form-create-clients").serialize(),
                                    beforeSend: function () {
                                        $('.create-clients #button-create-clients').button('loading');
                                        $(".create-clients.form-group").removeClass("has-error");
                                        $(".create-clients .help-block").remove();

                                    },
                                    complete: function () {
                                        $('.create-clients #button-create-clients').button('reset');
                                    },
                                    success: function (json) {
                                        var data = json['data'];
                                        $('.create-clients #span-loading').remove();
                                        $('.create-clients#modal-create-clients').modal('hide');
                                        $('#form-create-clients').trigger("reset");
                                        $('#uclients').append('<option value="' + data.id + '" selected="selected">' + data.nom_complet + '</option>');
                                        $('#uclients').trigger('change');
                                        //$('#uclients').select2('refresh');
                                        console.log(data);
                                        toastr.success('success');
                                    },
                                    error: function (error, textStatus, errorThrown) {
                                        toastr.warning('error');
                                    }


                                });
                            }
                        });

                    });

                    $('#btn_valider').click(function (e) {
                        var cpt = parseInt($('#cpt_error').val());
                        if (cpt != 0) {
                            e.preventDefault();
                            toastr.warning('Regler les probleme');
                        }


                    });
                    $('#cpt_error').hide();
                });

            </script>
            <script>


                /*

                 if(selectedValues.length>0)
                 {
                     axios.get('/admin/changemanagers/'+selectedValues)
                         .then((response) => {
                             if (Object.keys(response.data).length)
                             {
                                 $('#pemployes').empty().select2({allowClear: true,placeholder: 'Choisir les employes...', data: response.data});

                             }else
                             {
                                 toastr.warning('Aucun Employe');
                                 $('#pemployes').empty().select2({allowClear: true,placeholder: 'Choisir les employes...', data: []});

                             }

                         }).catch((error) => {
                         //let status = error.response.statusText;
                         console.log(error);
                         toastr.error("status "+status);
                         //Generic.loaderStop();

                     });
                 }else
                 {
                     $('#pemployes').empty().select2({allowClear: true,placeholder: 'Choisir les employes...', data: []});

                 }
                 */

                $(document).on('change', '.select2produit', function (e, who) { $('.qte_stock_change').trigger('change');});
                $(document).on('change', '.qte_stock_change', function (e, who) {
                    /*console.log(e);
                    e.stopPropagation? e.stopPropagation() : e.cancelBubble = true;
                    e.stopPropagation();
                    if(who === "machine")
                        alert('machine!');
                    else
                        alert('human!');*/
                    let qte = $(this).val();
                    let produit = $(this).parent().prev().children().first().val();
                    var span_text = $(this).next().text();
                    if (produit) {
                        axios.post('/admin/checkQteStock', {produit: produit}).then((response) => {
                            if (response.data >= qte) {
                                if (span_text != "") {
                                    var x1 = parseInt($('#cpt_error').val());
                                    x1--;
                                    $('#cpt_error').val(x1);
                                }
                                $(this).next().text("");
                            } else {

                                if (span_text == "") {
                                    var x1 = parseInt($('#cpt_error').val());
                                    x1++;
                                    $('#cpt_error').val(x1);
                                }
                                $(this).next().text("Tu as sur le stock juste " + response.data);
                                toastr.warning('Qte de stock instifusant');


                            }
                        }).catch((error) => {
                            //let status = error.response.statusText;
                            console.log(error);
                            toastr.error("status " + status);
                            //Generic.loaderStop();

                        });
                    } else {
                        toastr.warning('selectionner le produit');
                    }


                });

            </script>

@stop
