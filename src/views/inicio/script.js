import { QS, QSA } from '@selectors'

/* Carousel */
const CAROUSEL_TIME_INTERVAL = 8000
const $carouselElement = QS('#carousel-main')
const $carouselItems = [...QSA('.carousel-item')]
const $prevButton = QS('#data-carousel-prev')
const $nextButton = QS('#data-carousel-next')
const carouselItemsOptions = []

const carouselItems = $carouselItems.map(($el, index) => {
  carouselItemsOptions.push({
    position: index,
    el: QS('#carousel-item-indicator-' + index)
  })

  return {
    position: index,
    el: $el
  }
})

const carouselOptions = {
  defaultPosition: 1,
  interval: CAROUSEL_TIME_INTERVAL,

  indicators: {
    activeClasses: 'bg-red-mary dark:border-white',
    inactiveClasses: 'bg-gray-300 hover:bg-gray-400',
    items: carouselItemsOptions
  }
}

const carouselInstanceOptions = {
  id: $carouselElement.id,
  override: true
}

// eslint-disable-next-line no-undef
const carousel = new Carousel(
  $carouselElement,
  carouselItems,
  carouselOptions,
  carouselInstanceOptions
)

carousel.cycle()

$prevButton.addEventListener('click', () => {
  carousel.prev()
})

$nextButton.addEventListener('click', () => {
  carousel.next()
})

/* Tabs */
const tabsElement = QS('#tabs-proposito-mision-vision')

const tabElements = [
  {
    id: 'proposito',
    triggerEl: QS('#proposito-tab'),
    targetEl: QS('#proposito')
  },
  {
    id: 'mision',
    triggerEl: QS('#mision-tab'),
    targetEl: QS('#mision')
  },
  {
    id: 'vision',
    triggerEl: QS('#vision-tab'),
    targetEl: QS('#vision')
  }
]

function fnOnShow(tab) {
  for (const objItem of tab._items) {
    const $itemBtn = QS(`[data-tabs-target="#${objItem.id}"]`)

    // if (objItem.id === tab._activeTab.id) {
    //   setTimeout(() => {
    //     $itemBtn.setAttribute('class', options.activeClasses)
    //   }, 0)
    // } else {
    //   setTimeout(() => {
    //     $itemBtn.setAttribute('class', options.inactiveClasses)
    //   }, 0)
    // }

    setTimeout(() => {
      $itemBtn.classList.remove('border-blue-600')
      $itemBtn.classList.remove('border-gray-100')
      $itemBtn.classList.remove('hover:text-blue-600')
      $itemBtn.classList.remove('text-blue-600')
      $itemBtn.classList.remove('text-gray-500')

      $itemBtn.classList.remove('dark:border-blue-500')
      $itemBtn.classList.remove('dark:border-gray-700')
      $itemBtn.classList.remove('dark:hover:text-blue-400')
      $itemBtn.classList.remove('dark:hover:text-gray-300')
      $itemBtn.classList.remove('dark:text-blue-500')
      $itemBtn.classList.remove('dark:text-gray-400')
    }, 0)
  }
}

const options = {
  defaultTabId: 'proposito',
  activeClasses: 'border-b-2 text-red-mary hover:text-red-mary border-red-mary',
  inactiveClasses:
    'border-b-0 text-black hover:text-gray-600 border-black hover:border-gray-300',
  onShow: fnOnShow
}
const instanceOptions = {
  id: 'tabs-proposito-mision-vision',
  override: true
}

// eslint-disable-next-line no-undef
const tabs = new Tabs(tabsElement, tabElements, options, instanceOptions)
tabs.show('proposito')
setTimeout(() => {
  fnOnShow(tabs)
}, 1000)

/* Scroll to click navbar */
const itemsMenu = QSA('.scroll-to')
try {
  itemsMenu.forEach($link => {
    const itemToGo = QS(`${$link.dataset.scrollto}`)
    $link.addEventListener('click', event => {
      event.preventDefault()
      itemToGo.scrollIntoView({
        behavior: 'smooth'
      })
    })
  })
} catch (error) {}
