function openDialog(title, description) {
    const dialogOverlay = document.getElementById('dialogOverlay');
    const dialogTitle = document.getElementById('dialogTitle');
    const dialogDescription = document.getElementById('dialogDescription');
  
    dialogTitle.textContent = title;
    dialogDescription.textContent = description;
  
    dialogOverlay.style.display = 'flex';
  }
  
  function closeDialog() {
    const dialogOverlay = document.getElementById('dialogOverlay');
    dialogOverlay.style.display = 'none';
  }
  