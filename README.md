# ensure ✋🛑

✌🤩🤩Clean alternative syntax for enforcing business requirements. Useful for when your `if`s get too clunky.

```php
use function Shalvah\Ensure\when;
use function Shalvah\Ensure\ensure;

ensure($pilot->isInUniform)
  ->orElseDeny('Please put on your uniform', $pilot->getUniform());
when(!$pilot->isLicensed())
  ->ensure($flight->isTestFlight())
  ->orElseDeny('You are only allowed to fly test flights');
   
when(!$flightPlanHasBeenSubmitted)
  ->ensure(
    $whitelistedAirports->includes($destinationAirport)
    || $flight->isTestFlight()
  )
  ->orElseDeny("You need to submit a flight plan!");
```

## How to use
- Specify a **requirement** using `ensure()`. This rule must either be an expression which evaluates to **strict boolean `true`/`false`**, or a callable which returns **strict boolean `true`/`false`**:

```php
ensure($day == 'Saturday')->orElseDeny('Visiting hours are Saturdays only.');
ensure(function () use ($passenger) {
  $flight = Flight::getFlight($passenger->flightName);
  return $flight && $flight->passengers->includes($passenger->id);
})->orElseDeny('Visiting hours are Saturdays only.');
```

- You can also use `when` before calling `ensure`, to specify that the rule applies only in certain conditions:

```php
when($couponCodeWasApplied)
  ->ensure($product->isEligibleForDiscount())
  ->orElseDeny('Sorry, this product is not eligible for promotions.');
```

- In `orElseDeny()`, specify a `message` and any additional `data`. This package will throw a `RequirementFailedException` with the specified message and data. You can then listen for this in your code (preferably at one central location) and send the appropriate response to the user:

```php
try {
  ensure($user->isAllowedToView($product))
    ->orElseDeny('Sorry, this product is not eligible for promotions.', $this->suggestSimilarProducts($product, $user));
} catch (\Shalvah\Ensure\RequirementFailedException $e) {
    return response()->json([
      'message' => $e->getMessage(),
      'similar_products' => $e->getData()
    ], 400);
}

// or you could use set_exception_handller 
// or whatever mechanism your framework uses
```

## Installation

```bash
composer require shalvah/ensure
```
