# Investment Platform API Documentation

## 🚀 Getting Started

**Base URL:** `https://pogo-exponent-jiffy.ngrok-free.dev` (or `http://localhost:8000` locally)

**Authentication:** Token-based using Laravel Sanctum

---

## 📋 Authentication Endpoints

### 1. Register User

**POST** `/api/auth/register`

Create a new user account.

```json
{
    "name": "John Investor",
    "email": "john@example.com",
    "password": "securePassword123",
    "password_confirmation": "securePassword123"
}
```

**Success Response (201):**

```json
{
    "user": {
        "id": 48,
        "name": "John Investor",
        "email": "john@example.com",
        "status": "active",
        "roles": [],
        "permissions": [],
        "created_at": "2026-06-23T08:34:43.000000Z",
        "updated_at": "2026-06-23T08:34:43.000000Z"
    },
    "token": "53|6E29jJvQ2TmrW6JK27QEvXyLSsNPi7CPsU16qEhy4bf26dcb"
}
```

---

### 2. Login

**POST** `/api/auth/login`

Authenticate with email and password to get a token.

```json
{
    "email": "test@example.com",
    "password": "test123456"
}
```

**Success Response (200):**

```json
{
    "user": {
        "id": 48,
        "name": "Test User",
        "email": "test@example.com",
        "status": "active",
        "roles": [],
        "permissions": [],
        "created_at": "2026-06-23T08:34:43.000000Z",
        "updated_at": "2026-06-23T08:34:43.000000Z"
    },
    "token": "53|6E29jJvQ2TmrW6JK27QEvXyLSsNPi7CPsU16qEhy4bf26dcb"
}
```

**Error Response (401):**

```json
{
    "message": "The provided credentials are incorrect."
}
```

**⚠️ Test Credentials:**

- **Email:** `test@example.com`
- **Password:** `test123456`

---

### 3. Get Current User

**GET** `/api/auth/user`

Retrieve authenticated user's profile.

**Headers Required:**

```
Authorization: Bearer YOUR_TOKEN_HERE
```

**Success Response (200):**

```json
{
    "user": {
        "id": 48,
        "name": "Test User",
        "email": "test@example.com",
        "status": "active",
        "roles": [],
        "permissions": [],
        "created_at": "2026-06-23T08:34:43.000000Z",
        "updated_at": "2026-06-23T08:34:43.000000Z"
    }
}
```

---

### 4. Logout

**POST** `/api/auth/logout`

Invalidate current token.

**Headers Required:**

```
Authorization: Bearer YOUR_TOKEN_HERE
```

**Success Response (200):**

```json
{
    "message": "Logged out successfully"
}
```

---

## 🏗️ Project Endpoints

### 5. List Projects

**GET** `/api/projects`

Get paginated list of all projects. **Public endpoint (no authentication required).**

**Query Parameters:**

- `page` (optional): Page number, default 1
- `per_page` (optional): Items per page, default 15

**Example:**

```
GET /api/projects?page=1&per_page=10
```

**Success Response (200):**

```json
{
    "data": [
        {
            "id": 1,
            "name": "jablah citymol",
            "description": "very good",
            "location": "jablah",
            "status": "active",
            "total_budget": "1222.00",
            "created_at": "2026-06-05T10:17:12.000000Z",
            "updated_at": "2026-06-05T10:17:12.000000Z"
        },
        {
            "id": 2,
            "name": "city toun",
            "description": "local syria",
            "location": "syria",
            "status": "active",
            "total_budget": "1000000.00",
            "created_at": "2026-06-07T14:56:38.000000Z",
            "updated_at": "2026-06-07T14:56:38.000000Z"
        }
    ],
    "links": {
        "first": "http://localhost:8000/api/projects?page=1",
        "last": "http://localhost:8000/api/projects?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://localhost:8000/api/projects",
        "per_page": 15,
        "to": 2,
        "total": 2
    }
}
```

---

## 🔐 Authentication Flow (Frontend Implementation)

### Step 1: Register/Login

```javascript
// Login
const response = await fetch(
    "https://pogo-exponent-jiffy.ngrok-free.dev/api/auth/login",
    {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
        body: JSON.stringify({
            email: "test@example.com",
            password: "test123456",
        }),
    },
);

const data = await response.json();
const token = data.token;

// Store token in localStorage
localStorage.setItem("auth_token", token);
```

### Step 2: Use Token in Subsequent Requests

```javascript
// Fetch protected resource
const token = localStorage.getItem("auth_token");

const response = await fetch(
    "https://pogo-exponent-jiffy.ngrok-free.dev/api/auth/user",
    {
        method: "GET",
        headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
        },
    },
);

const user = await response.json();
console.log(user);
```

### Step 3: Get Projects (No Auth Required)

```javascript
const response = await fetch(
    "https://pogo-exponent-jiffy.ngrok-free.dev/api/projects",
    {
        method: "GET",
        headers: {
            Accept: "application/json",
        },
    },
);

const projects = await response.json();
console.log(projects.data);
```

---

## 📝 Common Headers

All API requests should include:

```
Accept: application/json
Content-Type: application/json (for POST/PUT/PATCH requests)
```

For authenticated endpoints, include:

```
Authorization: Bearer YOUR_SANCTUM_TOKEN
```

---

## 🔍 CORS Status

✅ **CORS is enabled** - Frontend at `localhost:5173` can access API at:

- `http://localhost:8000` (local development)
- `https://pogo-exponent-jiffy.ngrok-free.dev` (external/production)

**Allowed Methods:** GET, POST, PUT, PATCH, DELETE, OPTIONS

**Allowed Headers:** Content-Type, Authorization, X-Requested-With, Accept, Origin

---

## ⚠️ Error Responses

### 401 Unauthorized

```json
{
    "message": "The provided credentials are incorrect."
}
```

### 422 Validation Error

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email has already been taken."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

### 500 Server Error

```json
{
    "message": "Server error message"
}
```

---

## 🧪 Testing with cURL

### Login

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"test123456"}'
```

### Get User (with token)

```bash
curl -X GET http://localhost:8000/api/auth/user \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

### Get Projects

```bash
curl -X GET http://localhost:8000/api/projects \
  -H "Accept: application/json"
```

---

## 📊 Available Endpoints Summary

| Method | Endpoint             | Auth | Purpose           |
| ------ | -------------------- | ---- | ----------------- |
| POST   | `/api/auth/register` | No   | Create new user   |
| POST   | `/api/auth/login`    | No   | Authenticate user |
| GET    | `/api/auth/user`     | Yes  | Get user profile  |
| POST   | `/api/auth/logout`   | Yes  | Logout user       |
| GET    | `/api/projects`      | No   | List projects     |

---

## 🚀 Frontend Setup (React)

```javascript
// Create a reusable API client
const API_BASE_URL = "https://pogo-exponent-jiffy.ngrok-free.dev";

const apiClient = {
    async request(endpoint, options = {}) {
        const token = localStorage.getItem("auth_token");
        const headers = {
            Accept: "application/json",
            "Content-Type": "application/json",
            ...options.headers,
        };

        if (token) {
            headers["Authorization"] = `Bearer ${token}`;
        }

        const response = await fetch(`${API_BASE_URL}${endpoint}`, {
            ...options,
            headers,
        });

        return response.json();
    },

    login: (email, password) =>
        apiClient.request("/api/auth/login", {
            method: "POST",
            body: JSON.stringify({ email, password }),
        }),

    getUser: () => apiClient.request("/api/auth/user"),

    getProjects: () => apiClient.request("/api/projects"),

    logout: () => apiClient.request("/api/auth/logout", { method: "POST" }),
};

// Usage in React component
export function LoginForm() {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");

    const handleLogin = async (e) => {
        e.preventDefault();
        const data = await apiClient.login(email, password);
        if (data.token) {
            localStorage.setItem("auth_token", data.token);
            // Redirect to dashboard
        }
    };

    return (
        <form onSubmit={handleLogin}>
            <input
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                placeholder="Email"
            />
            <input
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                placeholder="Password"
            />
            <button type="submit">Login</button>
        </form>
    );
}
```

---

## 📞 Support

For API issues or questions, check:

1. Console errors for CORS issues
2. Network tab to verify Authorization headers
3. Token expiration (regenerate token via login if needed)
