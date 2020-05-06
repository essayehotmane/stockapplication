@extends('voyager::master')
@section('css')
    <style>
        .invoice-box {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            margin-bottom: 5px;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {

        }

        .invoice-box table tr.top table td {
            padding-bottom: 0px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            border-right: 2px solid #eee;
            border-left: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            footer {
                display: block;
            }
        }

        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 1.6cm;
            }

            footer {
                display: none;
            }

            .noprint {
                display: none;
            }

        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
@endsection
@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="tel-repeater">Achat</h4>
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


                    <input type="button" name="btn_print" id="btn_print" value="Imprimer" class="btn btn-danger noprint"
                           onclick="window.print();return false;" style="float: right;">
                    <br>
                    <div class="invoice-box" id="un">
                        <table cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr class="top">
                                <td colspan="2">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="title">
                                                <img src="{{Voyager::image(setting('admin.logo_invoice')) }}"
                                                     style="width:30%; max-width:300px;">
                                            </td>

                                            <td class="pull-right">
                                                20/12/2020
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr class="information">
                                <td colspan="2">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td>

                                                Nom : 45 achraf1<br>

                                            </td>


                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>


                            <tr class="heading">
                                <td style="text-align: left;">
                                    Produit
                                </td>

                                <td style="text-align: left;">
                                    Prix
                                </td>
                                <td style="text-align: left;">
                                    Qte
                                </td>
                            </tr>
                            <tr class="item">
                                <td>
                                    math
                                </td>

                                <td>
                                    1500 DH
                                </td>
                                <td>
                                    75
                                </td>
                            </tr>
                            <tr class="item last">
                                <td>
                                    math
                                </td>

                                <td>
                                    A-M-2 :
                                </td>
                                <td>
                                    abderrahem
                                </td>
                            </tr>

                            <tr class="total" style="text-align: right;">
                                <td></td>

                                <td style="text-align: right;float: right; margin-left: 10px;">
                                    Total: 100 DH
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




@stop
@section('javascript')



@stop
