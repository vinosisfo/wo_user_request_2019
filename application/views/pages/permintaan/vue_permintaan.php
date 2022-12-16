<script>
    var Url = '<?php echo base_url();?>';                
        var app = new Vue({
            el: '#app',
            data: {

            edit_data: {
                id_karyawan    : '',
                nama_karyawan  : '',
                no_tlp         : '',
                alamat         : '',
                email          : '',
                id_departemen  : '',
                nama_departemen     : '',
                level          : ''
            },

            data_permintaan :[],
            detail_permintaan :[],
            vw_detail_permintaan : [],
            message         :[]

        },
        created() {
            this.getdata()
            this.dataTable = null; 

        },
        methods: {
            select_row(row){
                app.edit_data = row;
                $('#modal-default').modal('show');
            },

            formatPrice(value) {
            let val = (value/1).toFixed(2).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },

            getdata: function() {
                axios.get(Url+'c_permintaan/data_permintaan').then(
                    result => {
                        this.data_permintaan = result.data

                        // this.endLoading()
                        Vue.nextTick(function() {
                        // save a reference to the DataTable
                            this.dataTable =  $.fn.dataTable.ext.errMode = 'none';
                             table = $('#dttable').DataTable({
                                 'paging'      : true,
                                //'pageLength'  : 1,
                                 'lengthChange': false,
                                 'searching'   : true,
                                 'ordering'    : false,
                                 'info'        : true,
                                 'info'        : false,
                                 'autoWidth'   : true
 
                             });
                        });
                    });
            },

            detail: function(id_permintaan) {
                axios.get(Url+'c_permintaan/data_detail_permintaan/'+id_permintaan).then(
                    result => {
                        this.detail_permintaan = result.data
                        $('#modal-default').modal('show');
                    });
            },

            vwdetail: function(id_permintaan) {
                axios.get(Url+'c_permintaan/vw_detail_permintaan/'+id_permintaan).then(
                    result => {
                        this.vw_detail_permintaan = result.data
                        $('#modal-default1').modal('show');
                    });
            },

            tknapprove: function(id_permintaan) {
                axios.get(Url+'c_permintaan/vw_detail_permintaan/'+id_permintaan).then(
                    result => {
                        this.vw_detail_permintaan = result.data
                        $('#modal-default2').modal('show');
                    });
            },


            approve: function() {
                var vm = this;
                axios.post('c_permintaan/approve_permintaan',
                new FormData($('#f_approve')[0])).then(function(response) {
                //window.location.replace(Url+'C_admin');
                vm.showMessage("permintaan di approve");
                vm.getdata();
                $('#modal-default').modal('hide');

                }).catch(function(e) {
                        
                });
            },

            progres: function() {
                var vm = this;
                axios.post('c_permintaan/update_progres',
                new FormData($('#f_progres')[0])).then(function(response) {
                //window.location.replace(Url+'C_admin');
                vm.showMessage("progres berhasil diupdate");
                vm.getdata();
                $('#modal-default2').modal('hide');

                }).catch(function(e) {
                        
                });
            },

            hapus_data: function(id_permintaan) {
                var conf = confirm("data akan dihapus?");
                if(!conf) return true;
                var vm = this;
                axios.get(Url+'c_permintaan/delete_data/'+id_permintaan).then(function(response) {     
                    vm.showMessage("data berhasil di hapus");
                    vm.getdata();
                    //window.location.replace(apiUrl+'vue');
                })
            },

            showMessage: function(message, status = 'success') {
                this.message = {text:message, status:status}
                //this.removeMessage()
            },
            removeMessage: function() {
                var msg = this
                setTimeout(function() {
                    msg.message = {text:'', status:''}
                }, 3000)
            }

        }
    })
    </script>