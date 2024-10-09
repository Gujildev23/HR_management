# Import mysql connector
import mysql.connector
import datetime

# Define the connection
connection = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="face_id",
    port = "3307"
)

# Tables
#table = "attendance"
table = "register"

date_now = datetime.datetime.now() # Get the current date and time

# Define the cursor
cursor = connection.cursor()

# Define the query, insert a new record

query = f'ALTER TABLE `{table}` AUTO_INCREMENT=1'

#query = f"INSERT INTO {table} (name, role, time_in) VALUES ('Azrael', 'Employee', '{date_now}')"

# Execute the query
cursor.execute(query)

# Commit the changes
connection.commit()

print("Record inserted successfully")

# Fetch the results
result = cursor.fetchall()

# Print the results
for row in result:
    print(row)

# Close the connection
cursor.close()
connection.close()


