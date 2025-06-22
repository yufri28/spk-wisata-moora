<footer class="bg-white text-center text-lg-start">
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: #F0F0F0;">
        © 2025 Copyright:
        <a class="text-dark" href="https://www.instagram.com/yufrii__/">Yupi</a>
    </div>
    <!-- Copyright -->
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</script>
<script src="<?=base_url()?>assets/DataTables/jquery.js"></script>
<script src="<?=base_url()?>assets/DataTables/datatables.min.js"></script>
<!-- jquery datatables -->
<script>
$(document).ready(function() {
    var table = $('#table').DataTable({
        responsive: true,
        "lengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ],
        "scrollX": true,
        "scrollY": true,
    });
    var table = $('#table-subkriteria').DataTable({
        responsive: true,
        "lengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ],
        "scrollX": true,
        "scrollY": true,
    });
    // new $.fn.dataTable.FixedHeader(table);
});
</script>
</body>

</html>