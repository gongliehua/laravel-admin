    <!-- jQuery 3 -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- layui -->
    <script src="{{ asset('plugins/layui/layui.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- fileinput -->
    <script src="{{ asset('plugins/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-fileinput/js/locales/zh.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
        function clearCache() {
           layui.use('layer', function(){
               var layer = layui.layer;
               layer.ready(function(){
                   layer.confirm("确定要清空缓存吗？", function(index){
                       $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                       $.ajax({
                           url: "{{ route('admin.clear_cache') }}",
                           type: 'POST',
                           data: {},
                           dataType: "json",
                           success: function(res){
                               layui.use('layer', function () {
                                   var layer = layui.layer;
                                   layer.ready(function () {
                                       layer.msg(res.msg, {}, function(){
                                           location.reload();
                                       });
                                   });
                               });
                           },
                           error: function(){
                               layui.use('layer', function () {
                                   var layer = layui.layer;
                                   layer.ready(function () {
                                       layer.msg('网络错误');
                                   });
                               });
                           }
                       });
                   });
               });
           });
        }
    </script>
