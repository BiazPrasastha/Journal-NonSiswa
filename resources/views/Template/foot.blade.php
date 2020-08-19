<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
<script src="{{asset('assets/js/swipeTo.min.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/js/long-press-event.min.js')}}"></script>
<!-- Bootstrap JS -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/pooper.min.js')}}"></script>

<!-- Fontawesome JS -->
<script src="{{asset('assets/font/js/all.min.js')}}"></script>

<!-- Main Script -->
<script>
    // Validasi Form Tidak Boleh Kosong
		(function () {
			'use-strict';
			window.addEventListener('load', function () {
				var forms = document.getElementsByClassName('needs-validation');
				var validation = Array.prototype.filter.call(forms, function (form) {
					form.addEventListener('submit', function (event) {
						if (form.checkValidity() === false) {
							event.preventDefault();
							event.stopPropagation();
						}
						form.classList.add('was-validated');
					}, false);
				});
			}, false);
		})();

		// Validasi Karakter Yang Tidak Boleh Diinputkan Pada Form
		function getKey(e) {
			if (window.event)
				return window.event.keyCode;
			else if (e)
				return e.which;
			else
				return null;
		}

		function goodchars(e, goods, field) {
			var key, keychar;

			key = getKey(e);
			if (key == null)
				return true;

			keychar = String.fromCharCode(key);
			keychar = keychar.toLowerCase();
			goods = goods.toLowerCase();

			if (goods.indexOf(keychar) != -1)
				return true;

			if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
				return true;

			if (key == 13) {
				var i;
				for (i = 0; i < field.form.elements.length; i++)
					if (field == field.form.elements[i])
						break;
				i = (i + 1) % field.form.elements.length;
				field.form.elements[i].focus();
				return false;
			};

			return false;
		}

        $(function () {
            $('.item-swipe').swipeTo({
                minSwipe: 150,
                angle: 10,
                wrapScroll: 'body',
                binder: true,
                swipeStart: function () {
                    console.log('start');
                },
                swipeMove: function () {
                    console.log('move');
                },
                swipeEnd: function () {
                    console.log('end');
                },
            });
            getIe();
		});

		$(function () {
            $('.item-swipe.swipe-two').swipeTo({
                minSwipe: 100,
                angle: 10,
                wrapScroll: 'body',
                binder: true,
                swipeStart: function () {
                    console.log('start');
                },
                swipeMove: function () {
                    console.log('move');
                },
                swipeEnd: function () {
                    console.log('end');
                },
            });
            getIe();
        });

        $(function () {
            $('.item-swipe.swipe-one').swipeTo({
                minSwipe: 50,
                angle: 10,
                wrapScroll: 'body',
                binder: true,
                swipeStart: function () {
                    console.log('start');
                },
                swipeMove: function () {
                    console.log('move');
                },
                swipeEnd: function () {
                    console.log('end');
                },
            });
            getIe();
        });
</script>
</body>

</html>
