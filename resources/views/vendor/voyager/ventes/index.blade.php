@extends('voyager::master')
@section('css')
    <link rel="stylesheet" type="text/css" href={{asset('vendor/datatables/media/css/dataTables.bootstrap.css')}}>
    <link rel="stylesheet" type="text/css"
          href={{asset('vendor/datatables/extensions/Editor/css/dataTables.editor.css')}}>
    <link rel="stylesheet" type="text/css"
          href={{asset('vendor/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')}}>
@endsection
@section('content')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class=""></i> Ventes
        </h1>
        <a href="{{route("create_ventes")}}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>Ajouter Nouveau</span>
        </a>


        <!-- /.modal -->


    </div>
    <div class="page-content read container-fluid">
        <div class="row">

            <div class="col-md-12">

                <div class="col-md-12">
                    <div class="panel panel-visible" id="spy6">

                        <div class="panel-body pn mt20">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="datatable2" cellspacing="0"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th class="va-m text-center">Date Vente</th>
                                        <th class="va-m text-center">Nom Client</th>
                                        <th class="va-m text-center">Total Vente</th>
                                        <th class="va-m text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ventes as $ac)
                                        <tr>
                                            <td class="text-center">{{$ac->date_vente}}</td>
                                            <td class="text-center">{{$ac->nom_client}}</td>
                                            <td class="text-center">{{$ac->Total_vente}}</td>
                                            <td class="no-sort no-click" id="bread-actions">
                                                <a href="#" title="Supprimer"
                                                   class="btn btn-sm btn-danger pull-right delete"
                                                   data-id="{{$ac->vente_id}}" id="delete-{{$ac->vente_id}}">
                                                    <i class="voyager-trash"></i>
                                                    <span class="hidden-xs hidden-sm">
                                                        <!--View -->

                                                    </span>
                                                </a>
                                                <a href="{{route('invoice_ventes',[$ac->vente_id])}}" title="Invoice"
                                                   class="btn btn-sm btn-success pull-right invoice"
                                                   style="margin-left: 6px;">
                                                    <i class="voyager-news"></i>
                                                    <span class="hidden-xs hidden-sm">
                                                        <!--View -->

                                                    </span>
                                                </a>
                                                

                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }}
                        vente?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop
@section('javascript')
    <script src={{asset('vendor/datatables/media/js/jquery.dataTables.js')}}></script>
    <script src={{asset('vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}></script>
    <script src={{asset('vendor/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}></script>
    <script src={{asset('vendor/datatables/media/js/dataTables.bootstrap.js')}}></script>

    <script>
        $('#datatable2').dataTable({
            "language": {
                "sProcessing": "Traitement en cours...",
                "sSearch": "Rechercher&nbsp;:",
                "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                "sInfo": "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "sInfoEmpty": "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Pr&eacute;c&eacute;dent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                },
                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                }
            },
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [-1]
            }],
            "iDisplayLength": 5,
            "aLengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Tous"]
            ],
            "sDom": '<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',
            "oTableTools": {
                "sSwfPath": "\micro/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
            },
            "ordering": false


        });
        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = 'http://localhost:8000/admin/ventes/__id'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

    </script>
@stop
