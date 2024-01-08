import { NAME_LOCALSTORAGE } from '@constants'

export const setLS = params => {
  const keys = Object.keys(params)
  const values = Object.values(params)
  let objLS = getLS()
  objLS = objLS ?? {}
  keys.forEach((name, index) => {
    objLS[name] = values[index]
  })
  window.localStorage.setItem(NAME_LOCALSTORAGE, JSON.stringify(objLS))
}
export const getLS = () => {
  const objLS = JSON.parse(window.localStorage.getItem(NAME_LOCALSTORAGE)) ?? {}
  return objLS
}
