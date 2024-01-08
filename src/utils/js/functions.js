import { LANGUAGE } from '@constants'
import { QSA } from '@selectors'

const fnHabilitar = $element => {
  $element.removeAttribute('disabled')
}

export const habilitar = $element => {
  $element.removeAttribute('disabled')
  QSA('input, button, select', $element).forEach(el => {
    fnHabilitar(el)
  })
}

const fnDeshabilitar = $element => {
  $element.classList.remove('is-invalid')
  $element.classList.remove('is-valid')
  $element.setAttribute('disabled', '')
  limpiar($element)
}

export const limpiar = $element => {
  if (
    $element.type === 'text' ||
    $element.type === 'date' ||
    $element.type === 'password'
  ) {
    $element.value = ''
  }
  $element.checked = false

  /* Llamar al evento change del elemento */
  const event = new Event('change')
  $element.dispatchEvent(event)
}

export const deshabilitar = $element => {
  $element.setAttribute('disabled', '')
  QSA('input, button, select', $element).forEach(el => {
    fnDeshabilitar(el)
  })
}

export const isCedula = cedula => {
  const regex = /^(v|e|p|j|g)-[0-9]{7,9}$/i
  return regex.test(cedula)
}

export const isExpediente = expediente => {
  const regex = /^([a-z]{3}(p)?)-[0-9]{3}-[0-9]{5}((p|v|i|s)?)$/i
  return regex.test(expediente)
}

export const isSQLInjection = txt => {
  const regex =
    /(-{2,}|'?(\s+)?\w(\s+)?'?(\s+)?=(\s+)?'?(\s+)?\w(\s+)?'?|alter(\s+)|create(\s+)|delete(\s+)|drop(\s+)?|exec(ute){0,1}(\s+)|insert( +into){0,1}|merge(\s+)|select(\s+)|update(\s+)|union( +all){0,1})/i
  return regex.test(txt)
}

export const isBusqueda = busqueda => {
  const regex = /(\d+|(?!\s)\W+|_+)/
  return !regex.test(busqueda)
}

export const isElement = element => {
  return element instanceof window.Element
}

export const isEmail = email => {
  // eslint-disable-next-line no-useless-escape
  const regex = /^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/i
  return regex.test(email)
}

export const isMobile = () => {
  let check = false
  // eslint-disable-next-line no-useless-escape
  ;(function (a) {
    if (
      /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(
        a
      ) ||
      // eslint-disable-next-line no-useless-escape
      /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
        a.substr(0, 4)
      )
    ) {
      check = true
    }
  })(navigator.userAgent || navigator.vendor || window.opera)
  return check
}

export const isMobileOrTablet = () => {
  let check = false
  // eslint-disable-next-line no-useless-escape
  ;(function (a) {
    if (
      /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(
        a
      ) ||
      // eslint-disable-next-line no-useless-escape
      /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
        a.substr(0, 4)
      )
    ) {
      check = true
    }
  })(navigator.userAgent || navigator.vendor || window.opera)
  return check
}

export const loanDays = clasif => {
  if (!clasif) return null
  return clasif.toLowerCase().includes('estudiante') ? 3 : 5
}

export const isSunday = (param = {}) => {
  const sundayWord = getFecha({
    date: '2022-05-29',
    language: LANGUAGE,
    utc: true,
    options: {
      weekday: 'long'
    }
  })

  const dayWord = getFecha({
    ...param,
    language: LANGUAGE,
    options: {
      weekday: 'long'
    }
  })

  return dayWord === sundayWord
}

/* Función para manejar las fechas */
export const getFecha = (params = {}) => {
  /* Parámetros recibidos */
  const day = params.day || 0
  const month = params.month || 0
  const year = params.year || 0
  const options = params.options || {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    timeZone: 'UTC'
  }
  const language = params.language || 'fr-CA'
  const iso = params.iso || false
  let date = params.date || false
  const endOfDay = params.endOfDay || false
  const utc = params.utc || false

  /* Obtener Fecha  */
  let fecha = new Date()

  /* Timezone */
  const tzOffset = fecha.getTimezoneOffset() * 60000

  if (date) {
    const regex = /Z$/
    date = date.replace(regex, '')
    fecha = new Date(`${date}Z`)
  } else {
    fecha = new Date(fecha - tzOffset)
  }

  /* Timezone Offset */
  if (utc) {
    const tzOffsetHours = fecha.getTimezoneOffset()
    fecha.setMinutes(fecha.getMinutes() + tzOffsetHours)
  }

  /* Sumar días */
  const daysToSum = day + month * 30 + year * 365
  fecha.setDate(fecha.getDate() + daysToSum)

  /* Respuestas */
  if (iso) {
    fecha = fecha.toISOString().slice(0, -1)
    if (endOfDay) {
      const regex = /T.+/
      fecha = fecha.replace(regex, 'T23:59:59.000')
    }
    return fecha
  }
  return fecha.toLocaleString(language, options)
}

/* Función para saber si dos objetos tienen los mismos valores y misma estructura */
export const sameObjects = (obj1 = {}, obj2 = {}) => {
  const keys1 = Object.keys(obj1)
  const keys2 = Object.keys(obj2)

  if (keys1.length !== keys2.length) return false

  for (const key of keys1) {
    if (obj1[key] !== obj2[key]) {
      return false
    }
  }
  return true
}

/* Rebotar funciones */
let timeout
export const debounce = (callback, delay) => {
  const res = () => {
    clearTimeout(timeout)
    timeout = setTimeout(callback, delay)
  }
  res()
}

/* Abrir ventana con POST */
export const openWindowWithPost = (url, data) => {
  const form = document.createElement('form')
  form.target = '_blank'
  form.method = 'POST'
  form.action = url
  form.style.display = 'none'

  for (const key in data) {
    const input = document.createElement('input')
    input.type = 'hidden'
    input.name = key
    input.value = data[key]
    form.appendChild(input)
  }
  document.body.appendChild(form)
  form.submit()
  document.body.removeChild(form)
}
