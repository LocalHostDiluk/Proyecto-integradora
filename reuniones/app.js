const notesContainer = document.getElementById("notesContainer");

function showNoteForm() {
    document.getElementById("noteForm").classList.remove("hidden");
}

function saveNote() {
    const title = document.getElementById("noteTitle").value;
    const description = document.getElementById("noteDescription").value;
    const date = new Date().toLocaleDateString();
    const creatorId = document.getElementById("creatorId").value; 
    const recipientId = document.getElementById("recipientId").value; 

    if (title && description) {
        const newNote = {
            creatorId,
            recipientId,
            title,
            description,
            date
        };

        addNoteToDOM(newNote);

    
        document.getElementById("noteTitle").value = '';
        document.getElementById("noteDescription").value = '';

      
        document.getElementById("noteForm").classList.add("hidden");
    } else {
        alert("Por favor, completa todos los campos.");
    }
}

function addNoteToDOM(note) {
    const noteCard = document.createElement("div");
    noteCard.classList.add("note-card");

    noteCard.innerHTML = `
        <h3>${note.title}</h3>
        <p>${note.description}</p>
        <small>${note.date}</small>
        <div class="note-actions">
            <button onclick="editNote(this)">Edit</button>
            <button onclick="deleteNote(this)">Delete</button>
        </div>
        <!-- IDs ocultos -->
        <input type="hidden" value="${note.creatorId}">
        <input type="hidden" value="${note.recipientId}">
    `;

    notesContainer.appendChild(noteCard);
}

function editNote(button) {
    const noteCard = button.parentElement.parentElement;
    const title = prompt("Edita el título de la nota:", noteCard.querySelector("h3").textContent);
    const description = prompt("Edita la descripción de la nota:", noteCard.querySelector("p").textContent);

    if (title && description) {
        noteCard.querySelector("h3").textContent = title;
        noteCard.querySelector("p").textContent = description;
    }
}

function deleteNote(button) {
    const noteCard = button.parentElement.parentElement;
    notesContainer.removeChild(noteCard);
}
