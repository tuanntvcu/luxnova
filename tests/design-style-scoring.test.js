const assert = require('node:assert/strict');
const { calculateStyleMatch } = require('../assets/js/design-style-scoring');

const cases = [
	{
		name: 'Modern Luxury',
		answers: {
			buildingType: 'penthouse',
			area: 'over200',
			atmosphere: 'luxury',
			color: 'blackGrey',
			budget: 'over1b',
			family: 'youngCouple',
			priority: 'status',
		},
		expect: (result) => {
			assert.ok(['modernLuxury', 'luxury'].includes(result.primary.key));
			const modernLuxury = result.allResults.find((item) => item.key === 'modernLuxury');
			assert.ok(modernLuxury.percentage >= 88 && modernLuxury.percentage <= 97);
		},
	},
	{
		name: 'Japandi',
		answers: {
			buildingType: 'apartment',
			area: '70_100',
			atmosphere: 'cozy',
			color: 'naturalWood',
			budget: '300_600',
			family: 'youngCouple',
			priority: 'durable',
		},
		expect: (result) => {
			assert.equal(result.primary.key, 'japandi');
			assert.ok(result.allResults.slice(0, 3).some((item) => ['scandinavian', 'wabiSabi'].includes(item.key)));
		},
	},
	{
		name: 'Minimalist',
		answers: {
			buildingType: 'apartment',
			area: 'under70',
			atmosphere: 'minimal',
			color: 'neutral',
			budget: 'under300',
			family: 'single',
			priority: 'function',
		},
		expect: (result) => {
			assert.equal(result.primary.key, 'minimalist');
			assert.ok(result.allResults.slice(0, 3).some((item) => item.key === 'modern'));
			assert.ok(result.allResults.slice(0, 3).some((item) => item.key === 'scandinavian'));
			assert.ok(!result.allResults.slice(0, 3).some((item) => item.key === 'luxury'));
		},
	},
	{
		name: 'Indochine',
		answers: {
			buildingType: 'villa',
			area: '100_200',
			atmosphere: 'unique',
			color: 'naturalWood',
			budget: 'over1b',
			family: 'multiGen',
			priority: 'aesthetic',
		},
		expect: (result) => {
			assert.ok(result.allResults.slice(0, 2).some((item) => item.key === 'indochine'));
			assert.ok(result.allResults.slice(0, 3).some((item) => ['frenchClassic', 'luxury'].includes(item.key)));
		},
	},
	{
		name: 'Contemporary',
		answers: {
			buildingType: 'office',
			area: '100_200',
			atmosphere: 'unique',
			color: 'blackGrey',
			budget: '600_1b',
			family: 'single',
			priority: 'aesthetic',
		},
		expect: (result) => {
			assert.equal(result.primary.key, 'contemporary');
			assert.ok(result.allResults.slice(0, 3).some((item) => ['modern', 'modernLuxury'].includes(item.key)));
		},
	},
];

cases.forEach((testCase) => {
	const first = calculateStyleMatch(testCase.answers);
	const second = calculateStyleMatch(testCase.answers);

	assert.deepEqual(first, second, `${testCase.name} should be deterministic`);
	testCase.expect(first);
	console.log(`${testCase.name}: ${first.primary.name} (${first.primary.percentage}%)`);
});
