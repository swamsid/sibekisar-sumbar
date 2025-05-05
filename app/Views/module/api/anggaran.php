<style>
    .datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
        color   : #ccc !important;
        cursor  : no-drop;
    }

    #table-anggaran{
        width: 100%;
        font-size: 10pt;
    }

    #table-anggaran th, 
    #table-anggaran td{
        padding: 15px 5px;
        border-bottom: 1px solid #eee;
    }

    #table-anggaran th{
        font-weight: bold;
    }

    #table-anggaran tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>

<div class="content-wrapper" style="padding-top: 24px;">
    <div class="page-header" style="margin-bottom: 20px;">
        <span> <b style="font-weight: bold; font-size: 14pt;">API Realisasi Anggaran</b>&nbsp; <span style="font-size: 9pt;">(BPKAD Provinsi Jawa Timur)</span> </span>
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Api Center</a></li>
                <li class="breadcrumb-item active" aria-current="page">Realisasi Anggaran</li>
            </ol>
        </nav>
    </div>

    <div class="row page-content">
        <div class="col-xl-12" style="cursor: pointer;">
            <div class="card">
                <div class="card-body">
                    <form id="frmsearch" class="forms-sample form-horizontal">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label style="margin-bottom: 15px;">Tahun Periode</label>
                                    <select name="tahun" id="tahun-periode" style="color: #343a40;" class="form-control">
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label style="margin-bottom: 15px;">Tanggal Awal</label>
                                    <input type="text" id="awal" name="awal" class="form-control datepicker awal" style="background: white; cursor: pointer;" readonly>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label style="margin-bottom: 15px;">Tanggal Akhir</label>
                                    <input type="text" id="akhir" name="akhir" class="form-control datepicker akhir" style="background: white; cursor: pointer;" readonly>
                                </div>
                            </div>

                            <div class="col-md-2 text-right" style="padding-top: 30px;">
                                <button type="button" class="btn btn-primary" id="submit">Submit</button>
                            </div>
                        </div>
                    </form>

                    <div class="row" style="padding-bottom: 10px; border-top: 1px solid #ddd; margin-top: 20px;">
                        <div class="col-md-12">
                            <table id="table-anggaran">
                                <thead>
                                    <tr>
                                        <th width="35%">Nama Perangkat Daerah</th>
                                        <th class="text-right" width="25%">Jumlah Anggaran</th>
                                        <th class="text-right" width="25%">Realisasi Anggaran</th>
                                        <th class="text-center" width="15%">Persentase</th>
                                    </tr>
                                </thead>
    
                                <tbody>
                                    <tr><td colspan="4" class="text-center">Lengkapi inputan periode diatas, lalu klik tombol Submit</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>


