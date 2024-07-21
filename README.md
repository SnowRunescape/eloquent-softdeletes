# eloquent-softdeletes

Eloquent Status SoftDeletes is an extension for the Eloquent ORM to enable soft delete functionality using a status field. This approach allows you to mark records as deleted by setting a specific status value, making it easy to manage "deleted" records while keeping them in the database.

## Features

* Soft delete records by updating the status field.
* Customize the status value to indicate a soft delete.
* Seamlessly restore soft deleted records.
* Include or exclude soft deleted records in queries.

## Installation

To install this package, use Composer:

```bash
composer require snowrunescape/eloquent-softdeletes
```

## Usage

Use the Orderable trait in your Eloquent model.
Optionally, define the $sortable property in your model class to customize column names and options.

### Example

#### Setting Up Your Model

To enable status-based soft deletes in your model, use the SoftDeletes trait and define the status field and the value that indicates a soft delete.

```php
use Illuminate\Database\Eloquent\Model;
use SnowRunescape\SoftDeletes\SoftDeletes;

class YourModel extends Model
{
    use SoftDeletes;
}
```

#### Soft Deleting a Record

To soft delete a record, use the delete method. This will update the status field to the deleted status value.

```php
$model->delete();
```

#### Restoring a Record

To restore a soft deleted record, use the restore method. This will update the status field to a non-deleted status value.

```php
$model->restore();
```

#### Querying Soft Deleted Records

To include soft deleted records in a query, use the withTrashed method.

```php
$allRecords = YourModel::withTrashed()->get();
```

To only get soft deleted records, use the onlyTrashed method.

```php
$deletedRecords = YourModel::onlyTrashed()->get();
```

To exclude soft deleted records from a query, use the withoutTrashed method (this is the default behavior).

```php
$activeRecords = YourModel::withoutTrashed()->get();
```

## Contributing

Contributions are welcome! Please submit a pull request or open an issue to discuss your ideas.

## License

eloquent-softdeletes is made available under the MIT License (MIT). Please see [License File](https://github.com/SnowRunescape/eloquent-softdeletes/blob/master/LICENSE) for more information.
