const App = (() => {
  'use strict'

  // Debounced resize event (width only). [ref: https://paulbrowne.xyz/debouncing]
  function resize(a, b) {
    const c = [window.innerWidth]
    return window.addEventListener('resize', () => {
      const e = c.length
      c.push(window.innerWidth)
      if (c[e] !== c[e - 1]) {
        clearTimeout(b)
        b = setTimeout(a, 150)
      }
    }), a
  }

  // Bootstrap breakPoint checker
  function breakPoint(value) {
    let el, check, cls

    switch (value) {
      case 'xs': cls = 'd-none d-sm-block'; break
      case 'sm': cls = 'd-block d-sm-none d-md-block'; break
      case 'md': cls = 'd-block d-md-none d-lg-block'; break
      case 'lg': cls = 'd-block d-lg-none d-xl-block'; break
      case 'xl': cls = 'd-block d-xl-none'; break
      case 'smDown': cls = 'd-none d-md-block'; break
      case 'mdDown': cls = 'd-none d-lg-block'; break
      case 'lgDown': cls = 'd-none d-xl-block'; break
      case 'smUp': cls = 'd-block d-sm-none'; break
      case 'mdUp': cls = 'd-block d-md-none'; break
      case 'lgUp': cls = 'd-block d-lg-none'; break
    }

    el = document.createElement('div')
    el.setAttribute('class', cls)
    document.body.appendChild(el)
    check = el.offsetParent === null
    el.parentNode.removeChild(el)

    return check
  }

  // Shorthand for Bootstrap breakPoint checker
  function xs() { return breakPoint('xs') }
  function sm() { return breakPoint('sm') }
  function md() { return breakPoint('md') }
  function lg() { return breakPoint('lg') }
  function xl() { return breakPoint('xl') }
  function smDown() { return breakPoint('smDown') }
  function mdDown() { return breakPoint('mdDown') }
  function lgDown() { return breakPoint('lgDown') }
  function smUp() { return breakPoint('smUp') }
  function mdUp() { return breakPoint('mdUp') }
  function lgUp() { return breakPoint('lgUp') }

  // Show filename for bootstrap custom file input
  function customFileInput() {
    for (const el of document.querySelectorAll('.custom-file > input[type="file"]')) {
      const chooseText = el.nextElementSibling.innerText
      el.addEventListener('change', () => {
        const fileLength = el.files.length
        let filename = fileLength ? el.files[0].name : chooseText
        filename = fileLength > 1 ? fileLength + ' files' : filename // if more than one file, show '{amount} files'
        el.parentElement.querySelector('label').textContent = filename
      })
    }
  }

  // Dropdown hover
  function dropdownHover() {
    for (const el of document.querySelectorAll('.dropdown-hover')) {
      el.addEventListener('mouseenter', () => {
        lgUp() && el.classList.add('show')
      })
      el.addEventListener('mouseleave', () => {
        lgUp() && el.classList.remove('show')
      })
    }
  }

  // Background cover
  function backgroundCover() {
    for (const el of document.querySelectorAll('[data-cover]')) {
      el.style.backgroundImage = `url(${el.dataset.cover})`
    }
  }

  // Spinner input
  function customSpinner() {
    for (const el of document.querySelectorAll('.custom-spinner')) {
      const input = el.querySelector('input[type="number"]')
      const min = parseInt(input.min)
      const max = parseInt(input.max)
      const up = el.querySelector('.up')
      const down = el.querySelector('.down')
      up.addEventListener('click', () => {
        if (input.value < max) {
          input.value = input.value.trim() == '' ? 0 : parseInt(input.value) + 1
          input.dispatchEvent(new Event('change'))
        }
      })
      down.addEventListener('click', () => {
        input.value.trim() == '' && (input.value = min)
        if (input.value > min) {
          input.value = input.value.trim() == '' ? min : parseInt(input.value) - 1
          input.dispatchEvent(new Event('change'))
        }
      })
    }
  }

  // Toggle sidebar collapse or expand
  function toggleSidebar() {
    for (const el of document.querySelectorAll('[data-toggle="sidebar"]')) {
      el.addEventListener('click', e => {
        lgUp() ? document.body.classList.toggle('sidebar-collapse') : document.body.classList.toggle('sidebar-expand')
        const sidebarTransition = parseFloat(getComputedStyle(document.querySelector('.sidebar'))['transitionDuration']) * 1000
        setTimeout(() => {
          document.dispatchEvent(new Event('sidebar:update'))
        }, sidebarTransition)
        document.querySelector('.sidebar-body').scrollTop = 0
        e.preventDefault()
      })
    }
  }

  // Remember sidebar scroll position
  function rememberSidebarPosition() {
    const sidebar = document.querySelector('.sidebar')
    const sidebarBody = sidebar.querySelector('.sidebar-body')
    let bodyClass = document.body.classList
    let scrollPosition = 0
    sidebarBody.addEventListener('scroll', function () {
      this.scrollTop > 0 && (scrollPosition = this.scrollTop) // save last scroll
    })
    for (const el of document.querySelectorAll('[data-toggle="sidebar"]')) {
      el.addEventListener('click', () => {
        if (!bodyClass.contains('sidebar-collapse') || bodyClass.contains('sidebar-expand')) {
          sidebarBody.scrollTop = scrollPosition // restore position on expanded
        }
      })
    }
    sidebar.addEventListener('mouseenter', () => {
      if (bodyClass.contains('sidebar-collapse') && lgUp()) {
        sidebarBody.scrollTop = scrollPosition // restore on hover
      }
    })
    sidebar.addEventListener('mouseleave', () => {
      if (bodyClass.contains('sidebar-collapse') && lgUp()) {
        sidebarBody.scrollTop = 0 // reset on unhover
      }
    })
  }

  // Nav Sub
  function navSub(id, toggle = true) {
    const nav = document.querySelector(id)
    if (nav) {
      for (const el of nav.querySelectorAll('.dropdown-toggle')) {
        el.addEventListener('click', function (e) {
          if (toggle) {
            for (const shown of this.closest('ul').querySelectorAll('.show')) {
              this != shown && shown.classList.remove('show')
            }
          }
          this.classList.toggle('show')
          document.dispatchEvent(new Event('sidebar:update')) // used for perfect-scrollbar updates
          e.preventDefault()
        })
      }
      for (const el of nav.querySelectorAll('.active')) {
        if (!el.classList.contains('nav-link')) {
          el.closest('.nav-item').querySelector('.nav-link').classList.add('active', 'show')
          document.dispatchEvent(new Event('sidebar:update'))
        }
      }
    }
  }

  // Custom scrollbar for sidebar
  function sidebarBodyCustomScrollBar() {
    const sidebarBody = document.querySelector('.sidebar .sidebar-body')
    if (sidebarBody) {
      let psSidebar
      resize(() => {
        if (lgUp()) {
          sidebarBody.classList.contains('ps') ? psSidebar.update() : psSidebar = new PerfectScrollbar(sidebarBody, { wheelPropagation: false })
        } else {
          sidebarBody.classList.contains('ps') && psSidebar.destroy()
        }
      })()

      // Update scrollbar
      document.addEventListener('sidebar:update', () => {
        lgUp() && psSidebar.update()
      })
    }
  }

  // Functional card toolbar
  function cardToolbar() {
    for (const el of document.querySelectorAll('[data-action]')) {
      el.addEventListener('click', function (e) {
        const card = this.closest('.card')
        switch (this.dataset.action) {
          case 'fullscreen':
            card.classList.toggle('card-fullscreen')
            if (card.classList.contains('card-fullscreen')) {
              this.innerHTML = '<i class="material-icons">fullscreen_exit</i>'
              document.body.style.overflow = 'hidden'
            } else {
              this.innerHTML = '<i class="material-icons">fullscreen</i>'
              document.body.removeAttribute('style')
            }
            break;
          case 'close':
            card.remove()
            break;
          case 'reload':
            card.insertAdjacentHTML('afterbegin', '<div class="card-loader-overlay"><div class="spinner-border text-white" role="status"></div></div>')
            card.dispatchEvent(new Event('card:reload'))
            break;
          case 'collapse':
            const toggler = $(this)
            const target = $(toggler.attr('data-target'))
            const minusIcon = '<i class="material-icons">remove</i>'
            const plusIcon = '<i class="material-icons">add</i>'
            target
              .on('show.bs.collapse', () => toggler.html(minusIcon) )
              .on('hide.bs.collapse', () => toggler.html(plusIcon) )
            break;
        }
        e.preventDefault()
      })
    }
  }

  // Table with check all & bulk action
  function checkAll() {
    const activeTr= 'table-active'
    for (const el of document.querySelectorAll('.has-checkAll')) {
      const thCheckbox = el.querySelector('th input[type="checkbox"]')
      const tdCheckbox = el.querySelectorAll('tr > td:first-child input[type="checkbox"]')
      const bulkTarget = el.getAttribute('data-bulk-target')
      let activeClass = el.getAttribute('data-checked-class')
      activeClass = activeClass ? activeClass : activeTr
      thCheckbox.addEventListener('click', function () {
        for (const cb of tdCheckbox) {
          cb.checked = this.checked
          cb.checked ? cb.closest('tr').classList.add(activeClass) : cb.closest('tr').classList.remove(activeClass)
        }
        bulkTarget && toggleBulkDropdown(bulkTarget, tdCheckbox)
      })
      for (const cb of tdCheckbox) {
        cb.addEventListener('click', function () {
          this.checked ? this.closest('tr').classList.add(activeClass) : this.closest('tr').classList.remove(activeClass)
          bulkTarget && toggleBulkDropdown(bulkTarget, tdCheckbox)
        })
      }
    }
    function toggleBulkDropdown(el, tdCheckbox) {
      let count = 0
      const bulk_dropdown = document.querySelector(el)
      for (const cb of tdCheckbox) {
        cb.checked && count++
      }
      bulk_dropdown.querySelector('.checked-counter') && (bulk_dropdown.querySelector('.checked-counter').textContent = count)
      count != 0 ? bulk_dropdown.removeAttribute('hidden') : bulk_dropdown.setAttribute('hidden', '')
    }
  }

  // Set accordion active card
  function accordionActive() {
    $('.accordion-ui .collapse').on('show.bs.collapse', function () {
      this.closest('.card').classList.add('active')
    }).on('hide.bs.collapse', function () {
      this.closest('.card').classList.remove('active')
    })
  }

  // Scrollspy alternative
  function navSection() {
    if (xl() && document.querySelector('#navSection')) {
      let sections = []
      for (const el of document.querySelectorAll('section[id]')) {
        sections[el.id] = el.offsetTop
      }

      const navSection = document.querySelector('#navSection')
      for (const link of navSection.querySelectorAll('a')) {
        link.addEventListener('click', function (e) {
          const id = this.getAttribute('href').replace('#', '')
          window.scrollTo(0, sections[id])
          e.preventDefault()
        })
      }

      window.addEventListener('scroll', () => {
        let scrollPosition = document.documentElement.scrollTop || document.body.scrollTop
        for (const i in sections) {
          if (sections[i] <= scrollPosition) {
            for (const link of navSection.querySelectorAll('a')) {
              link.classList.remove('active')
            }
            navSection.querySelector('a[href="#' + i + '"]').classList.add('active')
          }
        }
      })
      window.dispatchEvent(new Event('scroll'))
    }
  }

  // Chat
  function chat() {
    if (document.querySelector('.chat-modal')) {
      const toggle = document.querySelectorAll('[data-toggle="chat"]')
      const action = document.querySelectorAll('.chat-modal .list-group-item-action')
      const modalContent = document.querySelectorAll('.chat-modal .modal-content')
      const detail = document.querySelector('#conversation-detail')
      const chatText = document.querySelector('.chat-modal textarea')
      const chatFile = document.querySelector('.chat-modal input[type="file"]')

      // Toggle conversation & contacts
      for (const el of toggle) {
        el.addEventListener('click', function (e) {
          for (const mc of modalContent) {
            mc.classList.remove('active') // hide all modal content
          }
          document.querySelector(el.dataset.target).classList.add('active') // add 'active' class to target
          e.preventDefault()
        })
      }

      // Show conversation detail
      for (const el of action) {
        el.addEventListener('click', function (e) {
          for (const mc of modalContent) {
            mc.classList.remove('active') // hide all modal content
          }
          detail.classList.add('active') // add 'active' class to conversation-detail
          const modalBody = detail.querySelector('.modal-body')
          modalBody.scrollTop = modalBody.scrollHeight - modalBody.clientHeight // scroll to bottom
          e.preventDefault()
          chatText.focus()
        })
      }

      // Autosize chat input
      if (typeof autosize === 'undefined') {
        let el = document.createElement('script')
        el.src = '../../plugins/autosize/autosize.min.js'
        document.head.appendChild(el)
        el.onload = () => autosize(chatText)
      } else {
        autosize(chatText)
      }

      // Chat attachment
      chatFile.addEventListener('change', function () {
        const fileLength = this.files.length
        const filename = fileLength ? (fileLength > 1 ? `${fileLength} files` : '1 file') : '<i class="material-icons">attachment</i>'
        this.parentElement.querySelector('span').innerHTML = filename
        chatText.focus()
      })

      // Send by enter
      chatText.addEventListener('keypress', function (e) {
        if (e.which == 13 && !e.shiftKey) {
          this.closest('form').submit()
          e.preventDefault()
        }
      })
    }
  }

  return {
    init: () => {
      toggleSidebar()
      rememberSidebarPosition()
      navSub('#menu')
      sidebarBodyCustomScrollBar()
      $('#searchModal').on('shown.bs.modal', () => searchInput.focus()) // Focus to search input when search modal shown
    },
    resize: callback => resize(callback),
    navSub: (id, toggle) => navSub(id, toggle),
    xs: () => xs(),
    sm: () => sm(),
    md: () => md(),
    lg: () => lg(),
    xl: () => xl(),
    smDown: () => smDown(),
    mdDown: () => mdDown(),
    lgDown: () => lgDown(),
    smUp: () => smUp(),
    mdUp: () => mdUp(),
    lgUp: () => lgUp(),
    customFileInput: () => customFileInput(),
    dropdownHover: () => dropdownHover(),
    backgroundCover: () => backgroundCover(),
    customSpinner: () => customSpinner(),
    cardToolbar: () => cardToolbar(),
    stopCardLoader: card => {
      let overlay = card.querySelector('.card-loader-overlay')
      overlay.parentNode.removeChild(overlay)
    },
    color: variant => getComputedStyle(document.body).getPropertyValue('--' + variant).trim(),
    checkAll: () => checkAll(),
    accordionActive: () => accordionActive(),
    navSection: () => navSection(),
    chat: () => chat(),
  }
})()

App.init()

// sample colors
const blue = App.color('primary')
const green = App.color('success')
const red = App.color('danger')
const yellow = App.color('warning')
const cyan = App.color('info')
const gray = App.color('secondary')
const black = App.color('dark')
const purple = App.color('purple')
const pink = App.color('pink')
const brown = '#795548'
const orange = '#ff9800'
const lime = '#cddc39'