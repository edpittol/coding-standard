<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\TypeHints;

use SlevomatCodingStandard\Sniffs\TestCase;

class UnionTypeHintFormatSniffTest extends TestCase
{

	public function testDisallowedWhitespaceNoErrors(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatDisallowedWhitespaceNoErrors.php', [
			'enable' => true,
		]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testDisallowedWhitespaceErrors(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatDisallowedWhitespaceErrors.php', [
			'enable' => true,
		]);

		self::assertSame(3, $report->getErrorCount());

		self::assertSniffError($report, 6, UnionTypeHintFormatSniff::CODE_DISALLOWED_WHITESPACE);
		self::assertSniffError(
			$report,
			8,
			UnionTypeHintFormatSniff::CODE_DISALLOWED_WHITESPACE,
			'Whitespace in type hint "int| false" is disallowed.'
		);
		self::assertSniffError(
			$report,
			8,
			UnionTypeHintFormatSniff::CODE_DISALLOWED_WHITESPACE,
			'Whitespace in type hint "int  | string |  bool" is disallowed.'
		);

		self::assertAllFixedInFile($report);
	}

	public function testShortNullableNotSetNoErrors(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatShortNullableNotSetNoErrors.php', [
			'enable' => true,
		], [UnionTypeHintFormatSniff::CODE_REQUIRED_SHORT_NULLABLE, UnionTypeHintFormatSniff::CODE_DISALLOWED_SHORT_NULLABLE]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testShortNullableRequiredNoErrors(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatShortNullableRequiredNoErrors.php', [
			'enable' => true,
			'shortNullable' => 'yes',
		], [UnionTypeHintFormatSniff::CODE_REQUIRED_SHORT_NULLABLE]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testShortNullableRequiredErrors(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatShortNullableRequiredErrors.php', [
			'enable' => true,
			'shortNullable' => 'yes',
		], [UnionTypeHintFormatSniff::CODE_REQUIRED_SHORT_NULLABLE]);

		self::assertSame(3, $report->getErrorCount());

		self::assertSniffError($report, 6, UnionTypeHintFormatSniff::CODE_REQUIRED_SHORT_NULLABLE);
		self::assertSniffError(
			$report,
			8,
			UnionTypeHintFormatSniff::CODE_REQUIRED_SHORT_NULLABLE,
			'Short nullable type hint in "null|bool" is required.'
		);
		self::assertSniffError(
			$report,
			8,
			UnionTypeHintFormatSniff::CODE_REQUIRED_SHORT_NULLABLE,
			'Short nullable type hint in "string|null" is required.'
		);

		self::assertAllFixedInFile($report);
	}

	public function testShortNullableDisallowedNoErrors(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatShortNullableDisallowedNoErrors.php', [
			'enable' => true,
			'shortNullable' => 'no',
		], [UnionTypeHintFormatSniff::CODE_DISALLOWED_SHORT_NULLABLE]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testShortNullableDisallowedErrors(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatShortNullableDisallowedErrors.php', [
			'enable' => true,
			'shortNullable' => 'no',
		], [UnionTypeHintFormatSniff::CODE_DISALLOWED_SHORT_NULLABLE]);

		self::assertSame(3, $report->getErrorCount());

		self::assertSniffError($report, 6, UnionTypeHintFormatSniff::CODE_DISALLOWED_SHORT_NULLABLE);
		self::assertSniffError(
			$report,
			8,
			UnionTypeHintFormatSniff::CODE_DISALLOWED_SHORT_NULLABLE,
			'Usage of short nullable type hint in "?bool" is disallowed.'
		);
		self::assertSniffError(
			$report,
			8,
			UnionTypeHintFormatSniff::CODE_DISALLOWED_SHORT_NULLABLE,
			'Usage of short nullable type hint in "?string" is disallowed.'
		);

		self::assertAllFixedInFile($report);
	}

	public function testNullPositionNotSetNoErrors(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatNullPositionNotSetNoErrors.php', [
			'enable' => true,
		], [UnionTypeHintFormatSniff::CODE_NULL_TYPE_HINT_NOT_ON_FIRST_POSITION, UnionTypeHintFormatSniff::CODE_NULL_TYPE_HINT_NOT_ON_LAST_POSITION]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testNullPositionFirstNoErrors(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatNullPositionFirstNoErrors.php', [
			'enable' => true,
			'nullPosition' => 'first',
		], [UnionTypeHintFormatSniff::CODE_NULL_TYPE_HINT_NOT_ON_FIRST_POSITION]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testNullPositionFirstErrors(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatNullPositionFirstErrors.php', [
			'enable' => true,
			'nullPosition' => 'first',
		], [UnionTypeHintFormatSniff::CODE_NULL_TYPE_HINT_NOT_ON_FIRST_POSITION]);

		self::assertSame(3, $report->getErrorCount());

		self::assertSniffError($report, 6, UnionTypeHintFormatSniff::CODE_NULL_TYPE_HINT_NOT_ON_FIRST_POSITION);
		self::assertSniffError(
			$report,
			8,
			UnionTypeHintFormatSniff::CODE_NULL_TYPE_HINT_NOT_ON_FIRST_POSITION,
			'Null type hint should be on first position in "bool|null|int".'
		);
		self::assertSniffError(
			$report,
			8,
			UnionTypeHintFormatSniff::CODE_NULL_TYPE_HINT_NOT_ON_FIRST_POSITION,
			'Null type hint should be on first position in "string|null|\Anything".'
		);

		self::assertAllFixedInFile($report);
	}

	public function testNullPositionLastNoErrors(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatNullPositionLastNoErrors.php', [
			'enable' => true,
			'nullPosition' => 'last',
		], [UnionTypeHintFormatSniff::CODE_NULL_TYPE_HINT_NOT_ON_LAST_POSITION]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testNullPositionLastErrors(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatNullPositionLastErrors.php', [
			'enable' => true,
			'nullPosition' => 'last',
		], [UnionTypeHintFormatSniff::CODE_NULL_TYPE_HINT_NOT_ON_LAST_POSITION]);

		self::assertSame(3, $report->getErrorCount());

		self::assertSniffError($report, 6, UnionTypeHintFormatSniff::CODE_NULL_TYPE_HINT_NOT_ON_LAST_POSITION);
		self::assertSniffError(
			$report,
			8,
			UnionTypeHintFormatSniff::CODE_NULL_TYPE_HINT_NOT_ON_LAST_POSITION,
			'Null type hint should be on last position in "bool|null|int".'
		);
		self::assertSniffError(
			$report,
			8,
			UnionTypeHintFormatSniff::CODE_NULL_TYPE_HINT_NOT_ON_LAST_POSITION,
			'Null type hint should be on last position in "string|null|\Anything".'
		);

		self::assertAllFixedInFile($report);
	}

	public function testShouldNotReportIfSniffIsDisabled(): void
	{
		$report = self::checkFile(__DIR__ . '/data/unionTypeHintFormatShortNullableNotSetNoErrors.php', [
			'enable' => false,
		]);
		self::assertNoSniffErrorInFile($report);
	}

}
