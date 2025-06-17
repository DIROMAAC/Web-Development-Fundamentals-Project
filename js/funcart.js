const accessToken = 'BQAgOiw4OHwMpflwywsC8izgge4zyhM4zXlKf88gLCm7LPcH3fhWy09msqs8f9NJpK2OOSaGqE49zIHODRqiaKeadM30DpKXPAiFqjWGXpZAR8fBqprv_pa07282UW8Sm8ylQ0x20XzYSJNxtfrxF3alon2QcTbvOiIQ8mSyWFbVwS1SnVxtFj0XZJQ4lNetTd_K4ZBEwrEkCgme9YPQaM1l5GA';

const apiUrl = 'https://api.spotify.com/v1/search?q=genre:pop&type=artist&limit=48';

let allArtists = []; // Almacena todos los artistas obtenidos

// Función para obtener artistas desde la API
async function fetchArtists() {
    try {
        console.log('Iniciando fetch a la API de Spotify...');
        const response = await fetch(apiUrl, {
            method: 'GET',
            headers: {
                Authorization: `Bearer ${accessToken}`,
            },
        });

        if (!response.ok) {
            throw new Error(`Error en la API: ${response.status} ${response.statusText}`);
        }

        const data = await response.json();

        if (!data.artists || !data.artists.items || data.artists.items.length === 0) {
            throw new Error('No se encontraron artistas en la respuesta.');
        }

        allArtists = data.artists.items; // Guardar los artistas obtenidos
        console.log('Artistas obtenidos:', allArtists);
        displayArtists(); // Mostrar todos los artistas obtenidos
    } catch (error) {
        console.error('Error al cargar artistas:', error);
        document.getElementById('artist-container').innerHTML = '<p>Error al cargar los artistas. Verifica la consola.</p>';
    }
}

// Función para mostrar los artistas en el contenedor
function displayArtists() {
    const artistContainer = document.getElementById('artist-container');
    artistContainer.innerHTML = ''; // Limpiar contenido previo

    if (!allArtists || allArtists.length === 0) {
        artistContainer.innerHTML = '<p>No hay artistas disponibles.</p>';
        return;
    }

    // Mostrar todos los artistas
    allArtists.forEach(artist => {
        const artistElement = document.createElement('a'); // Enlace hacia Spotify
        artistElement.href = artist.external_urls.spotify; // URL del perfil del artista en Spotify
        artistElement.target = '_blank'; // Abrir en nueva pestaña
        artistElement.classList.add('artist');
        artistElement.innerHTML = `
            <img src="${artist.images[0]?.url || 'default-image.jpg'}" alt="${artist.name}">
            <p>${artist.name}</p>
        `;
        artistContainer.appendChild(artistElement);
    });

    console.log(`Mostrando ${allArtists.length} artistas.`);
}

// Llamada inicial para cargar artistas
fetchArtists();
