const usersList = document.querySelector('.users-list')
setInterval(() => {
  let xhr = new XMLHttpRequest()
  xhr.open('GET', 'php/users.php', true)
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response
        if (!searchBar.classList.contains('active')) {
          usersList.innerHTML = data
        }
      }
    }
  }
  xhr.send()
}, 500)

const searchBar = document.querySelector('.search input')
searchBar.onkeyup = () => {
  let searchTerm = searchBar.value
  let xhr = new XMLHttpRequest()
  xhr.open('POST', 'php/search.php', true)
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response
        //console.log(data);
        usersList.innerHTML = data
      }
    }
  }
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
  xhr.send('searchTerm=' + searchTerm)
}
