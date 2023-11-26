-- Crear tabla 'statuses'
CREATE TABLE statuses (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla 'rols'
CREATE TABLE rols (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla 'users'
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    rol_id INTEGER REFERENCES rols(id) ON DELETE SET NULL,
    email_verified_at TIMESTAMP,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100),
    current_team_id INTEGER,
    profile_photo_path VARCHAR(2048),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla 'clients'
CREATE TABLE clients (
    id SERIAL PRIMARY KEY,
    phone VARCHAR(255),
    user_id INTEGER REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla 'workshops'
CREATE TABLE workshops (
    id SERIAL PRIMARY KEY,
    description VARCHAR(255),
    location TEXT,
    contact_info VARCHAR(255),
    user_id INTEGER REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla 'technicians'
CREATE TABLE technicians (
    id SERIAL PRIMARY KEY,
    phone VARCHAR(255),
    workshop_id INTEGER REFERENCES workshops(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla 'vehicles'
CREATE TABLE vehicles (
    id SERIAL PRIMARY KEY,
    brand VARCHAR(255),
    model VARCHAR(255),
    year INTEGER,
    licence_plate VARCHAR(255),
    client_id INTEGER REFERENCES clients(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla 'assistance_requests'
CREATE TABLE assistance_requests (
    id SERIAL PRIMARY KEY,
    client_id INTEGER REFERENCES clients(id) ON DELETE SET NULL,
    vehicle_id INTEGER REFERENCES vehicles(id) ON DELETE SET NULL,
    status_id INTEGER REFERENCES statuses(id) ON DELETE SET NULL,
    problem_description VARCHAR(255),
    latitud DECIMAL(12, 5),
    longitud DECIMAL(12, 5),
    photos TEXT,
    voice_note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla 'assistance_requests_workshop'
CREATE TABLE assistance_requests_workshop (
    id SERIAL PRIMARY KEY,
    price VARCHAR(255),
    workshop_id INTEGER REFERENCES workshops(id) ON DELETE SET NULL,
    technician_id INTEGER REFERENCES technicians(id) ON DELETE SET NULL,
    assistance_request_id INTEGER REFERENCES assistance_requests(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
