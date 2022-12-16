<script>
    var Url = '<?php echo base_url();?>';                
        var app = new Vue({
            el: '#app',
            data: {

            edit_data: {
                id_teknisi       : '',
                id_departemen    : '',
                nama_departemen  : '',
                nama_teknisi     : '',
                email            : '',
                no_tlpn          : ''
            },

            data_teknisi   :[],
            message        :[]

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
                axios.get(Url+'c_teknisi/data_teknisi').then(
                    result => {
                        this.data_teknisi = result.data

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


            // simpan_data: function() {
            //     axios.post('C_admin/simpan_data',
            //     new FormData($('#f_admin')[0])).then(function(response) {
            //     //window.location.replace(Url+'C_admin');
            //     alert('berhasil');
            //     location.reload();

            //     }).catch(function(e) {
                        
            //     });
            // },

            hapus_data: function(id_teknisi) {
                var conf = confirm("data akan dihapus?");
                if(!conf) return true;
                var vm = this;
                axios.get(Url+'c_teknisi/delete_data/'+id_teknisi).then(function(response) {     
                    vm.showMessage("data berhasil di hapus");
                    vm.getdata();
                    //window.location.replace(apiUrl+'vue');
                })
            },

            showMessage: function(message, status = 'success') {
                this.message = {text:message, status:status}
                // this.removeMessage()
            },
            removeMessage: function() {
                var msg = this
                setTimeout(function() {
                    msg.message = {text:'', status:''}
                }, 5000)
            }

        }
    })
    </script>