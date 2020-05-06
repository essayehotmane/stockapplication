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
            <i class=""></i> Out stock
        </h1>


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
                                        <th class="va-m text-center">Nom</th>
                                        <th class="va-m text-center">Quantité</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($produits as $ac)
                                        <tr>
                                            <td class="text-center">{{$ac->nom}}</td>
                                            <td class="text-center">{{$ac->qte_stock}}</td>

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
                        achat?</h4>
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
            $('#delete_form')[0].action = 'http://localhost:8000/admin/achats/__id'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

    </script>
@stop
