<img src="public/images/Footer%20Luiz%20Alves.png" style="margin-left: 5%; opacity: 38%;">
<footer class="footer mt-4 pt-4 pt-md-4 border-top">
    <div class="col-12 col-md text-center">
        <small class="d-block mb-3 text-muted">
            &copy; <?php echo (new DateTime('now'))->format('Y'); ?> - Desenvolvido por Irmãos Wan-Dall
        </small>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="public/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script>
    $('#modalExemplo').on('shown.bs.modal', function () {
        $('#modalExemplo').trigger('focus')
    })


    // $(function () {
    $('[data-toggle="tooltip"]').tooltip();
    // });

    // $('#btn-outline-info').tooltip(options)

    // const sound = new Audio('public/sounds/chamada.mp3')
    // document.querySelector('button, submit').addEventListener('click', () => {
    //     sound.play();
    // });

    //chamar novamente
    $('.btn-info').click(function () {
        if (confirm('Deseja chamar novamente?')) {
            // alert('chamando');
        }
    });
    // // chamar a página visor.php
    // $('#chamarProximo').click(function () {
    //     alert('Próximo');
    //     $('#conteudo').load('visor.php');
    // });
    //
    // $('#chamarProximoPrioritario').click(function () {
    //     alert('Próximo Prioritário');
    //     $('#conteudo').load('visor.php');
    // });


</script>
</body>
</html>