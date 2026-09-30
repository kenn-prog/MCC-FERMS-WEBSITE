/* MCC-FERMS interface behaviour: modals, toggles, mobile sidebar, toast. */
(function () {
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var closeModals = function () {
    document.querySelectorAll('[data-modal]').forEach(function (m) { m.hidden = true; });
  };

  document.addEventListener('click', function (e) {
    var t = e.target;
    var open = t.closest('[data-open]');
    if (open) { closeModals(); var m = document.getElementById(open.dataset.open); if (m) m.hidden = false; return; }
    if (t.closest('[data-close]')) { closeModals(); return; }
    if (t.matches('[data-modal]')) { t.hidden = true; return; }

    var tog = t.closest('[data-toggle]');
    if (tog) {
      tog.classList.toggle('on');
      var input = tog.previousElementSibling;
      if (input) input.value = tog.classList.contains('on') ? 1 : 0;
      return;
    }

    if (t.closest('[data-menu]')) { $('#sidebar').classList.add('open'); $('[data-scrim]').classList.add('open'); return; }
    if (t.matches('[data-scrim]')) { $('#sidebar').classList.remove('open'); t.classList.remove('open'); return; }

    var f = t.closest('form[data-click-submit]');
    if (f && !t.closest('button, a')) f.submit();
  });

  document.addEventListener('change', function (e) {
    if (e.target.matches('[data-auto]') && e.target.form) e.target.form.submit();
  });

  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModals(); });

  var toast = $('[data-toast]');
  if (toast) setTimeout(function () { toast.remove(); }, 2600);
})();
