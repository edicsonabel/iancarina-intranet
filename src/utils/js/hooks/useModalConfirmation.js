import { QS } from '@selectors'
import { isElement } from '@functions'

const useModalConfirmation = (param = {}) => {
  const title = param.title ?? 'Título del modal <code>title</code>'
  const body = param.body ?? 'Colocar un cuerpo del modal <code>body</code>'

  const $element = document.createElement('div')
  $element.setAttribute('class', 'modal fade')
  $element.setAttribute('data-bs-backdrop', 'static')
  $element.setAttribute('data-bs-keyboard', 'false')
  $element.setAttribute('tabindex', '-1')
  $element.setAttribute('aria-labelledby', 'modalConfirmationLabel')
  $element.setAttribute('aria-hidden', 'true')

  $element.innerHTML = `
    <div class='modal-dialog modal-dialog-centered'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='modalConfirmationLabel'>${title}</h5>
          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
        </div>
        <div class='modal-body'>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Cancelar</button>
          <button type='button' class='btn btn-success'>Confirmar</button>
        </div>
      </div>
    </div>
  `
  /* Insertando el body */
  const boxBody = QS('.modal-body', $element)
  if (isElement(body)) {
    boxBody.prepend(body)
  } else {
    boxBody.innerHTML = body
  }
  /* Elementos */
  const $confirmar = QS('button.btn-success', $element)
  const $cancelar = QS('button.btn-danger', $element)
  /* eslint-disable-next-line no-undef */
  const modal = new bootstrap.Modal($element)

  $element.addEventListener('hidden.bs.modal', () => $element.remove())
  $element.addEventListener('shown.bs.modal', () => $cancelar.focus())
  $element.addEventListener('keyup', event => {
    if (event.key === 'Escape') modal.hide()
  })

  return [modal, $element, $confirmar, $cancelar]
}

export default useModalConfirmation
