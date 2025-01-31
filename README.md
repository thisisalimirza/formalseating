# Medical School Formal Seating Application

An interactive web application for medical school students to select their seats for formal events. Students can sign up, log in, and choose their seats and plus-one seating arrangements on an interactive seating map.

## Features

- User authentication (signup/login)
- Interactive seating map with tables and seats
- Real-time seat selection and visualization
- Plus-one management
- View occupancy and attendee information

## Tech Stack

- Backend: Flask (Python)
- Frontend: React.js with Material-UI
- Database: MongoDB
- Authentication: JWT
- Deployment: Vercel

## Setup Instructions

1. Clone the repository
2. Set up Python virtual environment:
   ```bash
   python -m venv venv
   source venv/bin/activate  # On Windows: venv\Scripts\activate
   pip install -r requirements.txt
   ```

3. Install frontend dependencies:
   ```bash
   cd frontend
   npm install
   ```

4. Create a `.env` file in the root directory (copy from `.env.example`):
   ```
   MONGODB_URI=your_mongodb_uri
   JWT_SECRET_KEY=your_jwt_secret_key
   FLASK_ENV=development
   FLASK_APP=api/index.py
   ```

5. Start the development servers:
   ```bash
   # Start Flask backend (in root directory)
   flask run

   # Start React frontend (in frontend directory)
   cd frontend
   npm start
   ```

## Development

- Backend API runs on `http://localhost:5000`
- Frontend development server runs on `http://localhost:3000`

## Deployment

The application is configured for deployment on Vercel:

1. Install Vercel CLI:
   ```bash
   npm install -g vercel
   ```

2. Deploy:
   ```bash
   vercel
   ```

## License

MIT 