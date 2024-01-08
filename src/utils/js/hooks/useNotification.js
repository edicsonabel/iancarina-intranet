const useNotification = (param = {}) => {
  /* Prámetros */
  const type = param.type ?? 'success'
  const message = param.message ?? 'Debes enviar el parámetro <code class="text-white">message</code>'
  const autohide = param.autohide ?? true

  /* Elemento */
  const $element = document.createElement('div')
  $element.className = `toast align-items-center text-bg-${type} border-0 show mb-2`
  $element.innerHTML = `
  <div class='d-flex'>
    <div class='toast-body'>
      ${message}
    </div>
    <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
  </div>
  `
  /* Removiendo al ocultar */
  $element.addEventListener('hidden.bs.toast', () => $element.remove())

  if (autohide) {
    /* Removiendo notificación en 9 segundos */
    setTimeout(() => { $element.remove() }, 9000)
  } else {
    $element.classList.add('no-hide')
  }
  return $element
}

export default useNotification
