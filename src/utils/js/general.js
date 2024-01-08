/* UTILS */
import { QS, QSA } from '@selectors'
import useModalConfirmation from '@hooks/useModalConfirmation'

const $main = QS('#main')
const $navbar = QS('#navbar')
const $sidebarToggle = QS('#sidebarToggle')
const $inputTextArray = QSA('input[type="text"]')
const $btnLogout = QS('#btnLogout')
const $boxModal = QS('#boxModal')

/* Cancelar el REFRESH de página en botones */
QSA('form').forEach($form =>
  $form.addEventListener('submit', e => {
    e.preventDefault()
  })
)

/* Ocultar navbar */
try {
  $sidebarToggle.addEventListener('click', e => {
    $navbar.classList.toggle('active')
    $main.classList.toggle('col-lg-10')
    $main.classList.toggle('col-md-9')
  })
} catch (error) {}

/* Quitar clase is-invalid al escribir  */
$inputTextArray.forEach(input => {
  input.addEventListener('keyup', event => {
    if (
      input?.value.trim() &&
      event.key !== 'Enter' &&
      event.key !== 'Backspace' &&
      event.key !== 'Delete'
    ) {
      input.classList.remove('is-invalid')
    }
  })
})

/* Cerrar sessión */
try {
  $btnLogout.addEventListener('click', () => {
    const [bsModal, $elModal, $confirmar] = useModalConfirmation({
      title: '❌ Cerrar sesión',
      body: 'Confirme que desea salir de la aplicación'
    })

    /* Insertando modal en boxModal */
    $boxModal.prepend($elModal)
    bsModal.show()

    $confirmar.addEventListener('click', () => {
      window.location.replace('../logout/')
    })
  })
} catch (error) {}
