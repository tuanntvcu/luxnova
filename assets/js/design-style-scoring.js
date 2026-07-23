((root, factory) => {
	const api = factory();

	if (typeof module === 'object' && module.exports) {
		module.exports = api;
	}

	root.LuxNovaStyleScoring = api;
})(typeof globalThis !== 'undefined' ? globalThis : window, () => {
	const QUESTION_WEIGHTS = {
		buildingType: 0.8,
		area: 0.7,
		atmosphere: 1.5,
		color: 1.2,
		budget: 1.1,
		family: 0.8,
		priority: 1.4,
	};

	const STYLES = {
		modernLuxury: { name: 'Modern Luxury' },
		modern: { name: 'Modern' },
		japandi: { name: 'Japandi' },
		scandinavian: { name: 'Scandinavian' },
		contemporary: { name: 'Contemporary' },
		minimalist: { name: 'Minimalist' },
		wabiSabi: { name: 'Wabi Sabi' },
		indochine: { name: 'Indochine' },
		frenchClassic: { name: 'French Classic' },
		luxury: { name: 'Luxury' },
	};

	const ZERO_MATRIX = Object.keys(STYLES).reduce((matrix, key) => {
		matrix[key] = 0;
		return matrix;
	}, {});

	const score = (values) => ({ ...ZERO_MATRIX, ...values });

	const SCORING_MATRIX = {
		buildingType: {
			apartment: score({ modernLuxury: 4, modern: 5, japandi: 4, scandinavian: 4, contemporary: 3, minimalist: 4, wabiSabi: 2, indochine: 2, frenchClassic: 1, luxury: 2 }),
			townhouse: score({ modernLuxury: 4, modern: 4, japandi: 3, scandinavian: 3, contemporary: 4, minimalist: 3, wabiSabi: 3, indochine: 4, frenchClassic: 3, luxury: 4 }),
			villa: score({ modernLuxury: 5, modern: 3, japandi: 3, scandinavian: 2, contemporary: 4, minimalist: 2, wabiSabi: 3, indochine: 5, frenchClassic: 5, luxury: 5 }),
			penthouse: score({ modernLuxury: 5, modern: 4, japandi: 2, scandinavian: 2, contemporary: 5, minimalist: 3, wabiSabi: 1, indochine: 3, frenchClassic: 4, luxury: 5 }),
			office: score({ modernLuxury: 3, modern: 5, japandi: 2, scandinavian: 3, contemporary: 5, minimalist: 4, wabiSabi: 1, indochine: 2, frenchClassic: 1, luxury: 3 }),
		},
		area: {
			under70: score({ modernLuxury: 2, modern: 5, japandi: 4, scandinavian: 5, contemporary: 3, minimalist: 5, wabiSabi: 3, indochine: 2, frenchClassic: 1, luxury: 1 }),
			'70_100': score({ modernLuxury: 4, modern: 5, japandi: 5, scandinavian: 4, contemporary: 4, minimalist: 4, wabiSabi: 4, indochine: 3, frenchClassic: 2, luxury: 2 }),
			'100_200': score({ modernLuxury: 5, modern: 4, japandi: 4, scandinavian: 3, contemporary: 5, minimalist: 3, wabiSabi: 4, indochine: 5, frenchClassic: 4, luxury: 4 }),
			over200: score({ modernLuxury: 5, modern: 3, japandi: 3, scandinavian: 2, contemporary: 4, minimalist: 2, wabiSabi: 3, indochine: 5, frenchClassic: 5, luxury: 5 }),
		},
		atmosphere: {
			minimal: score({ modernLuxury: 2, modern: 5, japandi: 4, scandinavian: 4, contemporary: 3, minimalist: 5, wabiSabi: 3, indochine: 1, frenchClassic: 1, luxury: 1 }),
			cozy: score({ modernLuxury: 3, modern: 3, japandi: 5, scandinavian: 5, contemporary: 2, minimalist: 2, wabiSabi: 5, indochine: 4, frenchClassic: 3, luxury: 2 }),
			luxury: score({ modernLuxury: 5, modern: 2, japandi: 1, scandinavian: 1, contemporary: 4, minimalist: 1, wabiSabi: 1, indochine: 4, frenchClassic: 5, luxury: 5 }),
			nature: score({ modernLuxury: 2, modern: 3, japandi: 5, scandinavian: 4, contemporary: 2, minimalist: 3, wabiSabi: 5, indochine: 4, frenchClassic: 2, luxury: 1 }),
			unique: score({ modernLuxury: 4, modern: 3, japandi: 2, scandinavian: 1, contemporary: 5, minimalist: 2, wabiSabi: 4, indochine: 5, frenchClassic: 4, luxury: 4 }),
		},
		color: {
			whiteCream: score({ modernLuxury: 5, modern: 4, japandi: 4, scandinavian: 5, contemporary: 3, minimalist: 5, wabiSabi: 4, indochine: 3, frenchClassic: 4, luxury: 4 }),
			naturalWood: score({ modernLuxury: 4, modern: 3, japandi: 5, scandinavian: 4, contemporary: 2, minimalist: 3, wabiSabi: 5, indochine: 5, frenchClassic: 3, luxury: 3 }),
			blackGrey: score({ modernLuxury: 5, modern: 4, japandi: 1, scandinavian: 1, contemporary: 5, minimalist: 4, wabiSabi: 1, indochine: 2, frenchClassic: 2, luxury: 5 }),
			neutral: score({ modernLuxury: 4, modern: 5, japandi: 4, scandinavian: 4, contemporary: 4, minimalist: 5, wabiSabi: 4, indochine: 3, frenchClassic: 3, luxury: 3 }),
			unknown: score({}),
		},
		budget: {
			under300: score({ modernLuxury: 1, modern: 4, japandi: 3, scandinavian: 4, contemporary: 2, minimalist: 5, wabiSabi: 3, indochine: 1, frenchClassic: 1, luxury: 0 }),
			'300_600': score({ modernLuxury: 3, modern: 5, japandi: 5, scandinavian: 5, contemporary: 3, minimalist: 4, wabiSabi: 4, indochine: 3, frenchClassic: 2, luxury: 1 }),
			'600_1b': score({ modernLuxury: 5, modern: 4, japandi: 4, scandinavian: 3, contemporary: 5, minimalist: 3, wabiSabi: 3, indochine: 4, frenchClassic: 4, luxury: 4 }),
			over1b: score({ modernLuxury: 5, modern: 3, japandi: 3, scandinavian: 2, contemporary: 4, minimalist: 2, wabiSabi: 3, indochine: 5, frenchClassic: 5, luxury: 5 }),
		},
		family: {
			single: score({ modernLuxury: 3, modern: 5, japandi: 3, scandinavian: 3, contemporary: 5, minimalist: 5, wabiSabi: 2, indochine: 2, frenchClassic: 2, luxury: 3 }),
			youngCouple: score({ modernLuxury: 5, modern: 4, japandi: 5, scandinavian: 4, contemporary: 4, minimalist: 3, wabiSabi: 4, indochine: 3, frenchClassic: 2, luxury: 3 }),
			kids: score({ modernLuxury: 4, modern: 4, japandi: 4, scandinavian: 5, contemporary: 3, minimalist: 3, wabiSabi: 3, indochine: 4, frenchClassic: 3, luxury: 3 }),
			multiGen: score({ modernLuxury: 4, modern: 3, japandi: 3, scandinavian: 3, contemporary: 3, minimalist: 2, wabiSabi: 4, indochine: 5, frenchClassic: 5, luxury: 4 }),
		},
		priority: {
			aesthetic: score({ modernLuxury: 5, modern: 3, japandi: 4, scandinavian: 3, contemporary: 5, minimalist: 3, wabiSabi: 4, indochine: 5, frenchClassic: 5, luxury: 5 }),
			function: score({ modernLuxury: 3, modern: 5, japandi: 4, scandinavian: 4, contemporary: 3, minimalist: 5, wabiSabi: 2, indochine: 2, frenchClassic: 2, luxury: 2 }),
			budget: score({ modernLuxury: 1, modern: 4, japandi: 3, scandinavian: 4, contemporary: 2, minimalist: 5, wabiSabi: 3, indochine: 1, frenchClassic: 1, luxury: 0 }),
			durable: score({ modernLuxury: 4, modern: 4, japandi: 5, scandinavian: 4, contemporary: 3, minimalist: 3, wabiSabi: 5, indochine: 4, frenchClassic: 4, luxury: 4 }),
			status: score({ modernLuxury: 5, modern: 2, japandi: 1, scandinavian: 1, contemporary: 4, minimalist: 1, wabiSabi: 1, indochine: 4, frenchClassic: 5, luxury: 5 }),
		},
	};

	const ANSWER_LABELS = {
		buildingType: {
			apartment: 'căn hộ',
			townhouse: 'nhà phố',
			villa: 'biệt thự',
			penthouse: 'penthouse',
			office: 'văn phòng',
		},
		area: {
			under70: 'dưới 70m²',
			'70_100': '70-100m²',
			'100_200': '100-200m²',
			over200: 'trên 200m²',
		},
		atmosphere: {
			minimal: 'tối giản, gọn gàng',
			cozy: 'ấm cúng',
			luxury: 'sang trọng',
			nature: 'gần gũi thiên nhiên',
			unique: 'cá tính, độc đáo',
		},
		color: {
			whiteCream: 'trắng - kem',
			naturalWood: 'gỗ tự nhiên',
			blackGrey: 'đen - xám',
			neutral: 'màu trung tính',
			unknown: 'chưa xác định',
		},
		budget: {
			under300: 'dưới 300 triệu',
			'300_600': '300-600 triệu',
			'600_1b': '600 triệu - 1 tỷ',
			over1b: 'trên 1 tỷ',
		},
		family: {
			single: 'người độc thân',
			youngCouple: 'vợ chồng trẻ',
			kids: 'gia đình có con nhỏ',
			multiGen: 'gia đình nhiều thế hệ',
		},
		priority: {
			aesthetic: 'đẹp và thẩm mỹ',
			function: 'tối ưu công năng',
			budget: 'tiết kiệm chi phí',
			durable: 'bền, dễ sử dụng',
			status: 'sang trọng để thể hiện đẳng cấp',
		},
	};

	const clamp = (value, min, max) => Math.max(min, Math.min(max, value));

	const computeBonusPenalty = (answers) => {
		const adjustments = Object.keys(STYLES).reduce((result, key) => {
			result[key] = 0;
			return result;
		}, {});

		const add = (values) => {
			Object.entries(values).forEach(([styleKey, value]) => {
				adjustments[styleKey] += value;
			});
		};

		if (answers.budget === 'under300') {
			add({ luxury: -4, modernLuxury: -3, frenchClassic: -3, indochine: -1 });
		}

		if (answers.area === 'under70') {
			add({ frenchClassic: -2, luxury: -2, indochine: -1, modernLuxury: -1 });
		}

		if (answers.area === 'over200' && answers.budget === 'over1b') {
			add({ luxury: 2, modernLuxury: 2, frenchClassic: 1.5, indochine: 1 });
		}

		if (answers.atmosphere === 'luxury' && answers.priority === 'status') {
			add({ modernLuxury: 2, luxury: 2, frenchClassic: 1.5, contemporary: 0.5 });
		}

		if (answers.atmosphere === 'nature' && answers.color === 'naturalWood') {
			add({ japandi: 2, wabiSabi: 2, scandinavian: 1.5, indochine: 1 });
		}

		if (answers.atmosphere === 'minimal' && answers.priority === 'function') {
			add({ minimalist: 2, modern: 1.5, scandinavian: 1, japandi: 1 });
		}

		if (answers.atmosphere === 'unique' && answers.color === 'blackGrey') {
			add({ contemporary: 2, modernLuxury: 1.5, modern: 1, luxury: 0.5 });
		}

		return adjustments;
	};

	const buildReasonBullets = (answers, primary) => {
		const bullets = [];
		const building = ANSWER_LABELS.buildingType[answers.buildingType];
		const area = ANSWER_LABELS.area[answers.area];
		const budget = ANSWER_LABELS.budget[answers.budget];
		const family = ANSWER_LABELS.family[answers.family];
		const atmosphere = ANSWER_LABELS.atmosphere[answers.atmosphere];
		const color = answers.color !== 'unknown' ? ANSWER_LABELS.color[answers.color] : '';
		const priority = ANSWER_LABELS.priority[answers.priority];

		if (building || area) {
			bullets.push(`Phù hợp ${[building, area].filter(Boolean).join(' khoảng ')}.`);
		}
		if (budget) {
			bullets.push(`Ngân sách ${budget} tương thích với mức hoàn thiện của ${primary.name}.`);
		}
		if (family) {
			bullets.push(`Cấu trúc ${family} cần bố cục sống cân bằng và dễ sử dụng.`);
		}
		if (atmosphere) {
			bullets.push(`Bạn ưu tiên không gian ${atmosphere}, đúng tinh thần phong cách được gợi ý.`);
		}
		if (color) {
			bullets.push(`Gam ${color} hỗ trợ tốt cho vật liệu và ánh sáng của concept này.`);
		}
		if (priority) {
			bullets.push(`Yếu tố "${priority}" là điểm cộng quan trọng trong kết quả.`);
		}

		return bullets.slice(0, 5);
	};

	const calculateStyleMatch = (answers = {}) => {
		const styleKeys = Object.keys(STYLES);
		const rawScores = styleKeys.reduce((result, key) => {
			result[key] = 0;
			return result;
		}, {});
		let maxPossibleScore = 0;

		Object.entries(QUESTION_WEIGHTS).forEach(([questionKey, weight]) => {
			const answerKey = answers[questionKey];
			if (!answerKey || (questionKey === 'color' && answerKey === 'unknown')) {
				return;
			}

			const matrixRow = SCORING_MATRIX[questionKey] && SCORING_MATRIX[questionKey][answerKey];
			if (!matrixRow) {
				return;
			}

			maxPossibleScore += 5 * weight;
			styleKeys.forEach((styleKey) => {
				rawScores[styleKey] += (matrixRow[styleKey] || 0) * weight;
			});
		});

		const adjustments = computeBonusPenalty(answers);

		const allResults = styleKeys.map((styleKey) => {
			const scoreValue = rawScores[styleKey] + adjustments[styleKey];
			const baseMatch = maxPossibleScore > 0 ? clamp(scoreValue / maxPossibleScore, 0, 1) : 0;
			const rawPercentage = Math.round(Math.pow(baseMatch, 0.72) * 100);

			return {
				key: styleKey,
				name: STYLES[styleKey].name,
				percentage: clamp(rawPercentage, 0, 97),
				rawPercentage: clamp(rawPercentage, 0, 97),
				score: Number(scoreValue.toFixed(2)),
			};
		}).sort((a, b) => b.score - a.score || b.percentage - a.percentage || a.name.localeCompare(b.name));

		const topResults = allResults.slice(0, 3).map((item) => ({ ...item }));

		if (topResults.length) {
			const topScore = topResults[0].rawPercentage;
			const confidenceBoost = topScore >= 85 ? 0 : topScore >= 75 ? 5 : topScore >= 65 ? 10 : 12;

			if (topResults[0].score > 0) {
				topResults[0].percentage = clamp(topResults[0].percentage + confidenceBoost, 18, 97);
			}
		}

		for (let index = 1; index < topResults.length; index += 1) {
			if (topResults[index].score <= 0) {
				continue;
			}

			const gap = index === 1 ? 3 : 5;
			topResults[index].percentage = clamp(Math.min(topResults[index].percentage, topResults[index - 1].percentage - gap), 18, 97);
		}

		topResults.forEach((topResult) => {
			const original = allResults.find((result) => result.key === topResult.key);
			if (original) {
				original.percentage = topResult.percentage;
			}
		});

		const primary = topResults[0] || null;

		return {
			primary: primary ? {
				key: primary.key,
				name: primary.name,
				percentage: primary.percentage,
				score: primary.score,
			} : null,
			alternatives: topResults.slice(1).map((item) => ({
				key: item.key,
				name: item.name,
				percentage: item.percentage,
				score: item.score,
			})),
			allResults,
			reasons: primary ? buildReasonBullets(answers, primary) : [],
		};
	};

	return {
		QUESTION_WEIGHTS,
		SCORING_MATRIX,
		STYLES,
		ANSWER_LABELS,
		computeBonusPenalty,
		calculateStyleMatch,
	};
});
