# QuickDB - Database Framework

The Lightweight PHP Database Framework to Accelerate Development.

---

## Introduction

QuickDB is a lightweight PHP database framework designed to simplify and accelerate database interactions. It provides a set of easy-to-use methods to perform common database operations such as `get`, `select`, `update`, `has`, `insert`, `delete`, and `query`.

## Installation

Simply include the QuickDB class in your project.

```php
require_once 'path/to/QuickDB.php';
```

## Usage

### Initialize the Database Connection

Create an instance of the `Database` class by providing the necessary database credentials.

```php
$db = new Database('localhost', 'username', 'password', 'database_name');
```

### Methods

#### get

Fetch a single record from a table based on specific conditions.

```php
$result = $db->get('table_name', "`column_name` = 'value'");
print_r($result);
```

#### select

Fetch multiple records from a table based on specific conditions.

```php
$results = $db->select('table_name', "`column_name` = 'value'");
print_r($results);
```

#### update

Update records in a table based on specific conditions.

```php
$data = ['column1' => 'new_value1', 'column2' => 'new_value2'];
$success = $db->update('table_name', $data, "`column_name` = 'value'");
echo $success ? "Update successful" : "Update failed";
```

#### has

Check if records exist in a table based on specific conditions.

```php
$exists = $db->has('table_name', "`column_name` = 'value'");
echo $exists ? "Record exists" : "Record does not exist";
```

#### insert

Insert a new record into a table.

```php
$data = ['column1' => 'value1', 'column2' => 'value2'];
$insert_id = $db->insert('table_name', $data);
echo "Inserted record ID: " . $insert_id;
```

#### delete

Delete records from a table based on specific conditions.

```php
$success = $db->delete('table_name', "`column_name` = 'value'");
echo $success ? "Delete successful" : "Delete failed";
```

#### query

Execute a custom SQL query.

```php
$sql = "SELECT * FROM table_name WHERE `column_name` = 'value'";
$results = $db->query($sql);
print_r($results);
```

## Contributing

Feel free to fork this repository and submit pull requests. For major changes, please open an issue first to discuss what you would like to change.

## License

This project is licensed under the MIT License - see the [LICENSE](https://opensource.org/licenses/MIT) file for details.
