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

const options = {
  defaultTabId: 'proposito',
  activeClasses: 'text-red-mary hover:text-red-mary border-red-mary',
  inactiveClasses:
    'text-black hover:text-gray-600 border-black hover:border-gray-300'
}
const instanceOptions = {
  id: 'tabs-proposito-mision-vision',
  override: true
}

// eslint-disable-next-line no-undef
const tabs = new Tabs(tabsElement, tabElements, options, instanceOptions)
tabs.show('proposito')
tabs.getTab('mision')
tabs.getActiveTab()

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
