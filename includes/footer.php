</div>
<style>
    footer {
        background-color: rgb(2, 17, 31);
    }
</style>
<footer class=" text-white text-center py-3 mt-auto">
    &copy; <?php echo date("Y"); ?> Employee Management System.
</footer>
<script>
    function toggleSubMenu() {
        const submenu = document.getElementById("employeesubmenu");
        submenu.classList.toggle("show");
    }
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    });
</script>

</body>

</html>