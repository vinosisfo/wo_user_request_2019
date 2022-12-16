<style>
    @page {
        size         : 21cm 29.5cm potrait;
        margin-left  : 5px !important;
        margin-top   : 10px !important;
        margin-right : 5px !important;
        margin-bottom: 30px !important;
        font-size    : 10px;
        font-family  : Helvetica;
    }

    hr {
        border    : none;
        height    : 1px;
        width     : 100%;
        text-align: left;
        /* Set the hr color */
        color: #333; /* old IE */
        background-color: #333; /* Modern Browsers */
    }


    .table_karyawan>tr>th{
        vertical-align: top !important;
    }

    .table_karyawan>tr>td{
        padding       : 10px !important;
        vertical-align: top !important;
        /* font-size: 12px; */
    }
    
    .border_top{
        border-top : 1 px solid black;
    }

    .border_bottom{
        border-bottom : 1 px solid black;
    }
</style>
<table class="customers">
    <tr>
        <td>PT. Tridharma Kencana </td>
    </tr>
    <tr>
        <td>Cisait. Kec.Kragilan Serang, Banten 42183</td>
    </tr>
    <tr>
        <td>Author By @supriyono || 081317555430 || vinosisfo94@gmail.com</td> 
    </tr>
</table>
<hr>
    <p>Laporan Permintaan Mingguan <?php echo $date1.' s/d '.$date2 ?></p>
<hr>
<table style="max-width: 98%; min-width : 95%;">
    <thead>
        <tr>
            <th style="text-align : left;">No</th>
            <th style="text-align : left;">Tanggal</th>
            <th style="text-align : left;">Inventaris</th>
            <th style="text-align : left;">Keterangan</th>
            <th style="text-align : left;">Tujuan</th>
            <th style="text-align : left;">Keterangan MTC</th>
            <th style="text-align : left;">Keterangan Teknisi</th>
            <th style="text-align : left;">Status</th>
            <th style="text-align : left;">Tgl Selesai</th>
        </tr>
        <tr>
            <th colspan="9"><hr></th>
        </tr>
    </thead>
    <?php
    $no    = 0;
    $urut  = 0;
    $type2 = '';
    foreach ($list->result() as $data) {
        $no++;
        $urut+=1;
        $type1=$data->nama_departemen.$data->MINGGU;
        if($type1<>$type2){
            if($urut>1){?>
            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>
            <?php } ?>
                <tr>
                    <td colspan="9">
                        <?php echo strtoupper($data->nama_departemen) ?> Minggu Ke : <?php echo $data->MINGGU ?><br>
                        <hr>
                    </td>
                </tr>
        <?php 
        $type2 = $type1;
        $urut  = 1;
        } ?>
        <tr>
            <td><?php echo $urut ?></td>
            <td><?php echo $data->tgl_permintaan ?></td>
            <td><?php echo $data->nama_inventaris ?></td>
            <td><?php echo $data->keterangan ?></td>
            <td><?php echo $data->tujuan ?></td>
            <td><?php echo $data->keterangan_mtn ?></td>
            <td><?php echo $data->keterangan_tkn ?></td>
            <td><?php echo $data->status_detail ?></td>
            <td><?php echo $data->tgl_selesai ?></td>
        </tr>
    <?php } ?>
</table>

<script type="text/php">
    if (isset($pdf)) {
        // open the PDF object - all drawing commands will
        // now go to the object instead of the current page
        $footer = $pdf->open_object();

        // get height and width of page
        $w = $pdf->get_width();
        $h = $pdf->get_height();

        // get font
        $font      = $fontMetrics->get_font("helvetica", "normal");
        $txtHeight = $fontMetrics->get_font_height($font, 8);

        // draw a line along the bottom
        $y     = $h - 2 * $txtHeight - 5;
        $y_new = $h - 2 * $txtHeight - 12;
        $color = array(0, 0, 0);
        //$pdf->line(16, $y, $w - 16, $y, $color, 0);
        
        // set page number on the left side
        $date    = date('Y-m-d H:i:s');
        $ci      = & get_instance();
        $now     = date("Y-m-d H:i:s");
        $now_set = date("d M Y H:i:s",strtotime($now));
        $text    = "print date $now_set    Page: {PAGE_NUM} of {PAGE_COUNT}";
        $line    = "_";
        for($ii=1; $ii<=170;$ii++){
            $line.="_";
        }
        $text_line =$line;
        $pdf->page_text(15, $y_new, $text_line , $font, 6, $color);
        $pdf->page_text(400, $y, $text , $font, 7, $color);
        

        // close the object (stop capture)
        $pdf->close_object();

        // add the object to every page (can also specify
        // "odd" or "even")
        $pdf->add_object($footer, "all");
    }
</script>
