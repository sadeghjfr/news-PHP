<!DOCTYPE html>
<html lang="en">
</main>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="<?= asset('public/admin-panel/js/bootstrap.min.js') ?>"></script>
<script src="<?= asset('public/admin-panel/js/mdb.min.js') ?>"></script>

<script src="<?= asset('public/jquery-3.7.1.js') ?>"></script>
<script src="<?= asset('public/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= asset('public/jalalidatepicker/persian-date.min.js') ?>"></script>
<script src="<?= asset('public/jalalidatepicker/persian-datepicker.min.js') ?>"></script>

<script>

    $(document).ready(function () {

        CKEDITOR.replace('body');
        CKEDITOR.replace('summary');

        $("#published_at_view").persianDatepicker( {

            format: "YYYY-MM-DD HH:mm:ss",
            toolbox: {
                calendarSwitch: {
                    enable: true
                }
            },
            timePicker: {
                enabled: true
            },
            observe: true,
            altField: "#published_at",
        })
    })

</script>

</body>

</html>