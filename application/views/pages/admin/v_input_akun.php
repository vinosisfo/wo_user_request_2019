<div class="table-responsive">
    <form id="form_input" autocomplete="off">
        <table class="table table-condensed">
            <tr>
                <td>Username</td>
                <td>:</td>
                <td>
                    <input type="text" name="username" id="username" maxlength="50">
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td>:</td>
                <td>
                    <input type="password" name="password" id="password" maxlength="35">
                </td>
            </tr>
            <tr>
                <td>Level</td>
                <td>:</td>
                <td>
                    <select name="level" id="level">
                        <option value="">PILIH</option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="MANAGER DEPT">Manager departemen</option>
                        <option value="MANAGER MTN">Manager maintenance</option>
                        <option value="ADMIN DEPT">Admin dept</option>
                        <option value="TEKNISI">Teknisi</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <button id="btn_simpan" type="button" class="btn btn-primary" onclick="simpan_data(this)">Simpan</button> | 
                    <button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>
                </td>
            </tr>
        </table>
    </form>
</div>

<script>
    function simpan_data(){
        username = $("#username").val()
        password = $("#password").val()
        level    = $("#level").val()

        if(username==""){
            alert("Username Tidak Boleh Kosong")
            $("#username").focus()
            return false
        }

        if(password==""){
            alert("Password Tidak Boleh Kosong")
            $("#password").focus()
            return false
        }

        if(level==""){
            alert("Level Tidak Boleh Kosong")
            $("#level").focus()
            return false
        }

        $("#btn_simpan").prop("disabled",true)
        $.post("<?php echo base_url("c_akun/simpan_data")?>",$("#form_input").serialize(),function(data){
            if(data.pesan=="ok"){
                alert("Data Berhasil Disimpan")
                location.reload()
            }
        },"json").fail(function(data){
            alert("Error!!")
            $("#btn_simpan").prop("disabled",false)
            return false;
        })
    }
</script>