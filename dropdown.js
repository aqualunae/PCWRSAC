(() => {
    const dropdownMenuList = document.getElementsByClassName("dropdown")
    Array.from(dropdownMenuList).forEach(function(dropdown) {
        dropdown.addEventListener('keydown', (e) => {
            if ((e.key === "Enter" || e.key === "ArrowDown") && e.target === dropdown) {
                if (e.key === "ArrowDown") {
                    e.preventDefault()
                }
                Array.from(dropdown.children).forEach(child => {
                    if (!child.classList.contains("dropdown-header")) {
                        child.tabIndex = 0
                        child.style.display = "block"
                        child.addEventListener('keydown', (e) => {
                            if (e.key === "ArrowDown") {
                                e.preventDefault()
                                if (e.target.nextElementSibling) {
                                    e.target.nextElementSibling.focus()
                                } else {
                                    e.target.blur()
                                    Array.from(dropdown.children).forEach(child => {
                                        if (!child.classList.contains("dropdown-header")) {
                                            child.tabIndex = -1
                                            child.style.display = "none"
                                        }
                                    })
                                }
                            }
                        })
                    }
                })
                dropdown.children[1].focus()
            }
        })
        dropdown.lastElementChild.addEventListener('blur', () => {
            Array.from(dropdown.children).forEach(child => {
                if (!child.classList.contains("dropdown-header")) {
                    child.tabIndex = -1
                    child.style.display = "none"
                }
            })
        })
    })
})()