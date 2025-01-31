from flask import Flask, request, jsonify
from flask_cors import CORS
from flask_jwt_extended import JWTManager, create_access_token, jwt_required, get_jwt_identity
from pymongo import MongoClient
from bson import ObjectId
from datetime import timedelta
import os
from dotenv import load_dotenv
import bcrypt
from math import cos, sin, pi

# Load environment variables
load_dotenv()

app = Flask(__name__)
CORS(app, 
    origins=["http://localhost:3000"],
    methods=["GET", "POST", "PUT", "DELETE", "OPTIONS"],
    allow_headers=["Content-Type", "Authorization", "Access-Control-Allow-Credentials"],
    supports_credentials=True,
    expose_headers=["Access-Control-Allow-Origin"],
    max_age=600
)

# Add CORS headers to all responses
@app.after_request
def after_request(response):
    response.headers.add('Access-Control-Allow-Origin', 'http://localhost:3000')
    response.headers.add('Access-Control-Allow-Headers', 'Content-Type,Authorization')
    response.headers.add('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS')
    response.headers.add('Access-Control-Allow-Credentials', 'true')
    return response

# JWT Configuration
app.config['JWT_SECRET_KEY'] = os.getenv('JWT_SECRET_KEY', 'your-secret-key')
app.config['JWT_ACCESS_TOKEN_EXPIRES'] = timedelta(days=7)
jwt = JWTManager(app)

# MongoDB Configuration
MONGODB_URI = os.getenv('MONGODB_URI', 'mongodb://localhost:27017/seatingapp')
client = MongoClient(MONGODB_URI)
db = client.seatingapp

# Helper function to convert ObjectId to string
def serialize_object_id(obj):
    if isinstance(obj, ObjectId):
        return str(obj)
    return obj

# Add a root route for testing
@app.route('/')
def home():
    return jsonify({'message': 'Server is running'}), 200

# User Routes
@app.route('/api/auth/register', methods=['POST', 'OPTIONS'])
def signup():
    if request.method == 'OPTIONS':
        return jsonify({}), 200
        
    try:
        data = request.get_json()
        print("Received registration data:", data)  # Debug print
        
        if not data:
            return jsonify({'error': 'No data provided'}), 400
            
        required_fields = ['name', 'email', 'password']
        missing_fields = [field for field in required_fields if field not in data]
        if missing_fields:
            error_msg = f"Missing required fields: {', '.join(missing_fields)}"
            print("Error:", error_msg)  # Debug print
            return jsonify({'error': error_msg}), 400
        
        if db.users.find_one({'email': data['email']}):
            print("Error: Email already registered")  # Debug print
            return jsonify({'error': 'Email already registered'}), 400
        
        # Hash password
        hashed = bcrypt.hashpw(data['password'].encode('utf-8'), bcrypt.gensalt())
        
        user = {
            'name': data['name'],
            'email': data['email'],
            'password': hashed,
            'role': data.get('role', 'attendee'),
            'hasPlusOne': data.get('hasPlusOne', False),
            'selectedSeatId': None,
            'plusOneSeatId': None
        }
        
        result = db.users.insert_one(user)
        user_data = {
            'id': str(result.inserted_id),
            'name': user['name'],
            'email': user['email'],
            'role': user['role'],
            'hasPlusOne': user['hasPlusOne']
        }
        
        print("Successfully created user:", user_data)  # Debug print
        return jsonify(user_data), 201
        
    except Exception as e:
        print(f"Error during registration: {str(e)}")  # Debug print
        return jsonify({'error': str(e)}), 500

@app.route('/api/auth/login', methods=['POST'])
def login():
    if request.method == 'OPTIONS':
        return jsonify({}), 200
        
    try:
        data = request.get_json()
        print("Received login data:", data)  # Debug print
        
        if not data or 'email' not in data or 'password' not in data:
            print("Error: Missing email or password")  # Debug print
            return jsonify({'error': 'Email and password are required'}), 400
            
        user = db.users.find_one({'email': data['email']})
        if not user:
            print("Error: User not found")  # Debug print
            return jsonify({'error': 'Invalid credentials'}), 401
            
        # Check password using bcrypt
        if not bcrypt.checkpw(data['password'].encode('utf-8'), user['password']):
            print("Error: Invalid password")  # Debug print
            return jsonify({'error': 'Invalid credentials'}), 401
            
        # Create user data response
        user_data = {
            'id': str(user['_id']),
            'name': user['name'],
            'email': user['email'],
            'role': user.get('role', 'attendee'),
            'hasPlusOne': user.get('hasPlusOne', False)
        }
        
        # Create access token
        access_token = create_access_token(identity=str(user['_id']))
        
        print("Login successful for user:", user_data)  # Debug print
        return jsonify({
            'user': user_data,
            'access_token': access_token
        }), 200
        
    except Exception as e:
        print(f"Error during login: {str(e)}")  # Debug print
        return jsonify({'error': str(e)}), 500

@app.route('/api/auth/me', methods=['GET'])
def get_user():
    # This will be implemented later with proper authentication
    return jsonify({'error': 'Not implemented'}), 501

@app.route('/api/auth/logout', methods=['POST'])
def logout():
    # Since we're using cookie-based sessions, we just need to return a success response
    return jsonify({'message': 'Logged out successfully'})

# Table Routes
@app.route('/api/tables', methods=['GET', 'OPTIONS'])
def get_tables():
    if request.method == 'OPTIONS':
        return jsonify({}), 200
        
    try:
        tables = list(db.tables.find())
        for table in tables:
            table['_id'] = str(table['_id'])
            seats = list(db.seats.find({'tableId': table['_id']}))
            for seat in seats:
                seat['_id'] = str(seat['_id'])
                if seat['occupiedBy']:
                    occupant = db.users.find_one({'_id': ObjectId(seat['occupiedBy'])})
                    if occupant:
                        seat['occupiedBy'] = {
                            'name': occupant['name']
                        }
            table['seats'] = seats
        return jsonify(tables), 200
    except Exception as e:
        print(f"Error fetching tables: {str(e)}")
        return jsonify({'error': str(e)}), 500

@app.route('/api/tables', methods=['POST'])
def create_table():
    data = request.get_json()
    table = {
        'tableNumber': data['tableNumber'],
        'capacity': data['capacity'],
        'position': data['position'],
        'shape': data.get('shape', 'round'),
        'isReserved': False
    }
    
    result = db.tables.insert_one(table)
    table['_id'] = str(result.inserted_id)
    
    # Create seats for the table
    seats = []
    for i in range(1, table['capacity'] + 1):
        angle = (2 * 3.14159 * i) / table['capacity']
        radius = 50 if table['shape'] == 'round' else 40
        seat = {
            'seatNumber': i,
            'tableId': str(result.inserted_id),
            'position': {
                'x': table['position']['x'] + radius * cos(angle),
                'y': table['position']['y'] + radius * sin(angle)
            },
            'status': 'available',
            'occupiedBy': None,
            'isPlusOne': False
        }
        seat_result = db.seats.insert_one(seat)
        seat['_id'] = str(seat_result.inserted_id)
        seats.append(seat)
    
    table['seats'] = seats
    return jsonify(table), 201

# Seat Routes
@app.route('/api/seats', methods=['GET', 'OPTIONS'])
def get_seats():
    if request.method == 'OPTIONS':
        return jsonify({}), 200
        
    try:
        seats = list(db.seats.find())
        for seat in seats:
            seat['_id'] = str(seat['_id'])
            if seat['occupiedBy']:
                occupant = db.users.find_one({'_id': ObjectId(seat['occupiedBy'])})
                if occupant:
                    seat['occupiedBy'] = {
                        'name': occupant['name']
                    }
        return jsonify(seats), 200
    except Exception as e:
        print(f"Error fetching seats: {str(e)}")
        return jsonify({'error': str(e)}), 500

@app.route('/api/seats/select/<seat_id>', methods=['POST'])
@jwt_required()
def select_seat(seat_id):
    try:
        data = request.get_json()
        current_user_id = get_jwt_identity()
        
        # Get the user and their current seat selections
        user = db.users.find_one({'_id': ObjectId(current_user_id)})
        if not user:
            return jsonify({'error': 'User not found'}), 404
            
        # Get the selected seat
        seat = db.seats.find_one({'_id': ObjectId(seat_id)})
        if not seat:
            return jsonify({'error': 'Seat not found'}), 404
            
        # Check if this is the user's currently selected seat (unoccupy if it is)
        if seat.get('occupiedBy') == current_user_id:
            # Unoccupy the seat
            db.seats.update_one(
                {'_id': ObjectId(seat_id)},
                {
                    '$set': {
                        'status': 'available',
                        'occupiedBy': None,
                        'isPlusOne': False
                    }
                }
            )
            
            # Update user's seat selection
            if seat.get('isPlusOne'):
                db.users.update_one(
                    {'_id': ObjectId(current_user_id)},
                    {'$set': {'plusOneSeatId': None}}
                )
            else:
                db.users.update_one(
                    {'_id': ObjectId(current_user_id)},
                    {'$set': {'selectedSeatId': None}}
                )
                
            return jsonify({'message': 'Seat unoccupied successfully'})
            
        # If selecting a new seat, check seat availability
        if seat['status'] != 'available':
            return jsonify({'error': 'Seat is not available'}), 400
            
        # Check if user is trying to select more seats than allowed
        is_plus_one = data.get('isPlusOne', False)
        user_seats = list(db.seats.find({'occupiedBy': current_user_id}))
        
        if is_plus_one:
            if not user.get('hasPlusOne'):
                return jsonify({'error': 'You do not have plus one privileges'}), 400
            if any(s.get('isPlusOne') for s in user_seats):
                return jsonify({'error': 'You have already selected a plus one seat'}), 400
        else:
            if any(not s.get('isPlusOne') for s in user_seats):
                return jsonify({'error': 'You have already selected your seat'}), 400
        
        # Update seat
        db.seats.update_one(
            {'_id': ObjectId(seat_id)},
            {
                '$set': {
                    'status': 'occupied',
                    'occupiedBy': current_user_id,
                    'isPlusOne': is_plus_one
                }
            }
        )
        
        # Update user
        if is_plus_one:
            db.users.update_one(
                {'_id': ObjectId(current_user_id)},
                {'$set': {'plusOneSeatId': seat_id}}
            )
        else:
            db.users.update_one(
                {'_id': ObjectId(current_user_id)},
                {'$set': {'selectedSeatId': seat_id}}
            )
        
        return jsonify({'message': 'Seat selected successfully'})
        
    except Exception as e:
        print(f"Error selecting seat: {str(e)}")
        return jsonify({'error': str(e)}), 500

# Add this function after MongoDB configuration
def create_sample_tables():
    # Clear existing tables and seats
    db.tables.delete_many({})
    db.seats.delete_many({})
    
    # Create sample tables with better spacing
    tables_data = [
        {
            'tableNumber': 1,
            'capacity': 8,
            'position': {'x': 150, 'y': 150},  # Top-left
            'shape': 'round',
            'isReserved': False
        },
        {
            'tableNumber': 2,
            'capacity': 8,
            'position': {'x': 450, 'y': 150},  # Top-right
            'shape': 'round',
            'isReserved': False
        },
        {
            'tableNumber': 3,
            'capacity': 8,
            'position': {'x': 150, 'y': 400},  # Bottom-left
            'shape': 'round',
            'isReserved': False
        },
        {
            'tableNumber': 4,
            'capacity': 8,
            'position': {'x': 450, 'y': 400},  # Bottom-right
            'shape': 'round',
            'isReserved': False
        }
    ]
    
    for table_data in tables_data:
        result = db.tables.insert_one(table_data)
        table_id = str(result.inserted_id)
        
        # Create seats for the table in a circle
        for i in range(table_data['capacity']):
            angle = (2 * pi * i) / table_data['capacity']
            radius = 50  # pixels
            seat = {
                'seatNumber': i + 1,
                'tableId': table_id,
                'position': {
                    'x': table_data['position']['x'] + radius * cos(angle),
                    'y': table_data['position']['y'] + radius * sin(angle)
                },
                'status': 'available',
                'occupiedBy': None,
                'isPlusOne': False
            }
            db.seats.insert_one(seat)

# Add this route after the home route
@app.route('/api/init-sample-data', methods=['POST'])
def init_sample_data():
    try:
        create_sample_tables()
        return jsonify({'message': 'Sample tables and seats created successfully'}), 201
    except Exception as e:
        print(f"Error creating sample data: {str(e)}")
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True, port=5001) 