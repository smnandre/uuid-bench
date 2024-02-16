# UuidV4 Performances

## Code

### Before 

```php
$uuid = random_bytes(16);
$uuid[6] = $uuid[6] & "\x0F" | "\x40";
$uuid[8] = $uuid[8] & "\x3F" | "\x80";
$uuid = bin2hex($uuid);
$uuid = substr($uuid, 0, 8).'-'.substr($uuid, 8, 4).'-'.substr($uuid, 12, 4).'-'.substr($uuid, 16, 4).'-'.substr($uuid, 20, 12);
```

### After 

```php
$uuid = bin2hex(random_bytes(18));
$uuid[8] = $uuid[13] = $uuid[18] = $uuid[23] = '-';
$uuid[14] = '4';
$uuid[19] = ['8', '9', 'a', 'b', '8', '9', 'a', 'b', 'c' => '8', 'd' => '9', 'e' => 'a', 'f' => 'b'][$uuid[19]] ?? $uuid[19];
```


## Benchmarks

### Run

```shell
make install
make bench > results.txt
```

### Environment

* PHP 8.3.2
* opcache enabled
* xdebug disabled

### Results

    php vendor/bin/phpbench run --report=aggregate

| benchmark  | subject           | set | revs | its | mem_peak | mode      | rstdev |        |
|------------|-------------------|-----|------|-----|----------|-----------|--------|--------|
| MonoBench  | benchUuidV4Before |     | 1    | 1   | 1.000mb  | 633.000μs | ±0.00% |        |
| MonoBench  | benchUuidV4After  |     | 1    | 1   | 1.000mb  | 386.000μs | ±0.00% | `-39%` | 
| MultiBench | benchUuidV4Before |     | 1    | 1   | 1.000mb  | 7.000μs   | ±0.00% |        |
| MultiBench | benchUuidV4After  |     | 1    | 1   | 1.000mb  | 5.000μs   | ±0.00% | `-29%` |   

    php vendor/bin/phpbench run --report=aggregate --revs=100

| benchmark  | subject           | set | revs | its | mem_peak | mode      | rstdev |        |
|------------|-------------------|-----|------|-----|----------|-----------|--------|--------|
| MonoBench  | benchUuidV4Before |     | 100  | 1   | 1.000mb  | 616.260μs | ±0.00% |        |
| MonoBench  | benchUuidV4After  |     | 100  | 1   | 1.000mb  | 377.800μs | ±0.00% | `-39%` |
| MultiBench | benchUuidV4Before |     | 100  | 1   | 1.000mb  | 0.700μs   | ±0.00% |        |
| MultiBench | benchUuidV4After  |     | 100  | 1   | 1.000mb  | 0.460μs   | ±0.00% | `-34%` |

    php vendor/bin/phpbench run --report=aggregate --revs=10000

| benchmark  | subject           | set | revs  | its | mem_peak | mode      | rstdev |        |
|------------|-------------------|-----|-------|-----|----------|-----------|--------|--------|
| MonoBench  | benchUuidV4Before |     | 10000 | 1   | 1.000mb  | 631.257μs | ±0.00% |        |
| MonoBench  | benchUuidV4After  |     | 10000 | 1   | 1.000mb  | 388.530μs | ±0.00% | `-38%` |
| MultiBench | benchUuidV4Before |     | 10000 | 1   | 1.000mb  | 0.628μs   | ±0.00% |        |
| MultiBench | benchUuidV4After  |     | 10000 | 1   | 1.000mb  | 0.390μs   | ±0.00% | `-38%` |

    php vendor/bin/phpbench run --report=aggregate --iterations=100

| benchmark  | subject           | set | revs | its | mem_peak | mode      | rstdev  |        |
|------------|-------------------|-----|------|-----|----------|-----------|---------|--------|
| MonoBench  | benchUuidV4Before |     | 1    | 100 | 1.000mb  | 624.088μs | ±2.84%  |        |
| MonoBench  | benchUuidV4After  |     | 1    | 100 | 1.000mb  | 387.356μs | ±27.74% | `-38%` |
| MultiBench | benchUuidV4Before |     | 1    | 100 | 1.000mb  | 7.607μs   | ±24.15% |        |
| MultiBench | benchUuidV4After  |     | 1    | 100 | 1.000mb  | 5.033μs   | ±22.89% | `-34%` |

    php vendor/bin/phpbench run --report=aggregate --revs=100 --iterations=100

| benchmark  | subject           | set | revs | its | mem_peak | mode      | rstdev  |        |
|------------|-------------------|-----|------|-----|----------|-----------|---------|--------|
| MonoBench  | benchUuidV4Before |     | 100  | 100 | 1.000mb  | 618.662μs | ±0.44%  |        |
| MonoBench  | benchUuidV4After  |     | 100  | 100 | 1.000mb  | 377.381μs | ±0.68%  | `-39%` |
| MultiBench | benchUuidV4Before |     | 100  | 100 | 1.000mb  | 0.734μs   | ±19.14% |        |
| MultiBench | benchUuidV4After  |     | 100  | 100 | 1.000mb  | 0.463μs   | ±16.80% | `-37%` |


## 3v4l.org

### Before (https://3v4l.org/gIhSq)

```
Finding entry points
Branch analysis from position: 0
1 jumps found. (Code = 62) Position 1 = -2
filename:       /in/Rv7gv
function name:  (null)
number of ops:  25
compiled vars:  !0 = $uuid
line      #* E I O op 
```

### After (https://3v4l.org/Rv7gv)

```
Finding entry points
Branch analysis from position: 0
1 jumps found. (Code = 62) Position 1 = -2
filename:       /in/gIhSq
function name:  (null)
number of ops:  53
compiled vars:  !0 = $uuid
```

