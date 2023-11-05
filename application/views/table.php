<html>
<head>
<title>CSS Select Table Row</title>

</head>
<body>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>

<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
            <th>No</th>
                                        <th>Kode Site</th>
                                        <th>Nama Site</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Tipe User</th>
            </tr>
        </thead>
        <tbody>
                                   <?php $nomor=0; foreach ($datauser->result() as $u){ $nomor++;?>
                            
                                <tr class="<?php if ($nomor % 2 == 0) {echo "even gradeC";} else{echo "odd gradeX";}?>">
                                    <td class="center"><?php echo $nomor;?></td>
                                    <td class="center"><?php echo $u->kd_sap2?></td>
                                    <td class="center"><?php echo $u->NM_DEPO?></td>
                                    <td class="center"><?php echo $u->user ?></td>
                                    <td class="center"><?php echo $u->email ?></td>
                                    <?php if($u->tipe_user=="user_tb_ho"){?>
                                    <td class="center">Head Office</td>
                                    <?php } elseif($u->tipe_user=="user_depo"){ ?>
                                    <td class="center">Area</td>
                                    <?php } else{ ?>
                                    <td class="center"></td>
                                    <?php } ?>
                                </tr>
                                <?php }?>
                                </tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>

<script type="text/javascript">
$(document).ready(function() {
    var table = $('#example').DataTable();
 
    $('#example tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
    $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );
} );


</script>
</body>
</html>