      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; DAYTECH <?= date('Y',$user['date_created']); ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('asset/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('asset/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('asset/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('asset/'); ?>js/sb-admin-2.min.js"></script>
  <script>

  //menampilkan nama file saat akan diupload
  //jquery tolong carikan elemen .custom-file_inpu  saat di ubah isinya kemudian jalankan fungsi
  $('.custom-file-input').on('change', function(){
    let fileName  = $(this).val().split('\\').pop(); //ambil nm filenya
    $(this).next('.custom-file-label').addClass("selected").html(fileName); //lalu nama file nya isi ke dalam inputnya
  });


  //jquery tolong carikan elemen form-check-input  saat di click kemudian jalankan fungsi
  $('.form-check-input').on('click', function(){
    const menuId = $(this).data('menu'); //ambil datanya saat tombol click di ceklist
    const roleId = $(this).data('role');

    //jalankan ajax 
    $.ajax({
      url: "<?= base_url('admin/changeaccess'); ?>",
      type:'post',
      data: {
        menuId : menuId, 
        roleId : roleId
      },
      //jika sukses jalankan
      success: function(){
        document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
      }
    });

  });
</script>

</body>

</html>
