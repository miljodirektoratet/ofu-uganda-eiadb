<?php

return [
    "districts" => "
    CASE
    WHEN districts.id = 1 THEN 1
    WHEN districts.id = 2 THEN 2
    WHEN districts.id = 3 THEN 3
    WHEN districts.id = 4 THEN 53
    WHEN districts.id = 5 THEN 51
    WHEN districts.id = 6 THEN 52
    WHEN districts.id = 7 THEN 82
    WHEN districts.id = 8 THEN 54
    WHEN districts.id = 9 THEN 4
    WHEN districts.id = 10 THEN 14
    WHEN districts.id = 11 THEN 68
    WHEN districts.id = 12 THEN 69
    WHEN districts.id = 13 THEN 71
    WHEN districts.id = 14 THEN 118
    WHEN districts.id = 15 THEN 5
    WHEN districts.id = 16 THEN 84
    WHEN districts.id = 17 THEN 40
    WHEN districts.id = 19 THEN 72
    WHEN districts.id = 20 THEN 158
    WHEN districts.id = 21 THEN 56
    WHEN districts.id = 22 THEN 41
    WHEN districts.id = 23 THEN 85
    WHEN districts.id = 24 THEN 73
    WHEN districts.id = 25 THEN 42
    WHEN districts.id = 26 THEN 43
    WHEN districts.id = 27 THEN 70
    WHEN districts.id = 28 THEN 57
    WHEN districts.id = 30 THEN 16
    WHEN districts.id = 31 THEN 31
    WHEN districts.id = 32 THEN 129
    WHEN districts.id = 33 THEN 83
    WHEN districts.id = 34 THEN 76
    WHEN districts.id = 35 THEN 32
    WHEN districts.id = 36 THEN 149
    WHEN districts.id = 37 THEN 46
    WHEN districts.id = 38 THEN 33
    WHEN districts.id = 39 THEN 67
    WHEN districts.id = 40 THEN 47
    WHEN districts.id = 41 THEN 75
    WHEN districts.id = 42 THEN 182
    WHEN districts.id = 43 THEN 6
    WHEN districts.id = 44 THEN 48
    WHEN districts.id = 45 THEN 153
    WHEN districts.id = 46 THEN 152
    WHEN districts.id = 47 THEN 164
    WHEN districts.id = 48 THEN 49
    WHEN districts.id = 49 THEN 89
    WHEN districts.id = 50 THEN 12
    WHEN districts.id = 51 THEN 58
    WHEN districts.id = 52 THEN 17
    WHEN districts.id = 53 THEN 88
    WHEN districts.id = 54 THEN 59
    WHEN districts.id = 55 THEN 119
    WHEN districts.id = 56 THEN 60
    WHEN districts.id = 57 THEN 148
    WHEN districts.id = 58 THEN 117
    WHEN districts.id = 59 THEN 7
    WHEN districts.id = 60 THEN 127
    WHEN districts.id = 61 THEN 78
    WHEN districts.id = 62 THEN 146
    WHEN districts.id = 63 THEN 18
    WHEN districts.id = 64 THEN 145
    WHEN districts.id = 65 THEN 61
    WHEN districts.id = 66 THEN 138
    WHEN districts.id = 67 THEN 20
    WHEN districts.id = 68 THEN 93
    WHEN districts.id = 69 THEN 21
    WHEN districts.id = 70 THEN 143
    WHEN districts.id = 71 THEN 22
    WHEN districts.id = 72 THEN 92
    WHEN districts.id = 73 THEN 35
    WHEN districts.id = 74 THEN 62
    WHEN districts.id = 75 THEN 136
    WHEN districts.id = 76 THEN 37
    WHEN districts.id = 77 THEN 39
    WHEN districts.id = 78 THEN 126
    WHEN districts.id = 79 THEN 23
    WHEN districts.id = 80 THEN 120
    WHEN districts.id = 81 THEN 135
    WHEN districts.id = 82 THEN 24
    WHEN districts.id = 83 THEN 25
    WHEN districts.id = 84 THEN 9
    WHEN districts.id = 85 THEN 125
    WHEN districts.id = 86 THEN 134
    WHEN districts.id = 87 THEN 26
    WHEN districts.id = 88 THEN 91
    WHEN districts.id = 89 THEN 140
    WHEN districts.id = 90 THEN 132
    WHEN districts.id = 91 THEN 116
    WHEN districts.id = 92 THEN 87
    WHEN districts.id = 93 THEN 63
    WHEN districts.id = 94 THEN 64
    WHEN districts.id = 95 THEN 112
    WHEN districts.id = 96 THEN 137
    WHEN districts.id = 97 THEN 110
    WHEN districts.id = 98 THEN 10
    WHEN districts.id = 99 THEN 141
    WHEN districts.id = 100 THEN 108
    WHEN districts.id = 101 THEN 27
    WHEN districts.id = 102 THEN 104
    WHEN districts.id = 103 THEN 65
    WHEN districts.id = 105 THEN 106
    WHEN districts.id = 106 THEN 66
    WHEN districts.id = 107 THEN 115
    WHEN districts.id = 108 THEN 79
    WHEN districts.id = 109 THEN 80
    WHEN districts.id = 110 THEN 11
    WHEN districts.id = 111 THEN 122
    WHEN districts.id = 112 THEN 156
    WHEN districts.id = 113 THEN 128
    WHEN districts.id = 114 THEN 166
    WHEN districts.id = 115 THEN 154
    WHEN districts.id = 116 THEN 167
    WHEN districts.id = 117 THEN 114
    WHEN districts.id = 118 THEN 109
    WHEN districts.id = 119 THEN 175
    WHEN districts.id = 120 THEN 176
    WHEN districts.id = 121 THEN 139
    WHEN districts.id = 122 THEN 179
    WHEN districts.id = 123 THEN 173
    WHEN districts.id = 124 THEN 50
    WHEN districts.id = 126 THEN 8
    WHEN districts.id = 127 THEN 178
    WHEN districts.id = 129 THEN 86
    WHEN districts.id = 130 THEN 165
    WHEN districts.id = 131 THEN 168
    WHEN districts.id = 132 THEN 174
    WHEN districts.id = 133 THEN 172
    WHEN districts.id = 134 THEN 181
    ELSE NULL
    END AS district_id
",
    "risk" => function ($column) {
        return "
    CASE
    WHEN $column = 93 THEN 'high'
    WHEN $column = 94 THEN 'medium'
    WHEN $column = 95 THEN 'low'
    ELSE 'unknown'
    END
    ";
    },
    'categories' => "
    CASE
    WHEN projects.category_id =  1 THEN 5
    WHEN projects.category_id =  2 THEN 3
    WHEN projects.category_id =  3 THEN 13
    WHEN projects.category_id =  4 THEN 2
    WHEN projects.category_id =  5 THEN 5
    WHEN projects.category_id =  6 THEN 15
    WHEN projects.category_id =  7 THEN 12
    WHEN projects.category_id =  8 THEN 14
    WHEN projects.category_id =  9 THEN 24
    WHEN projects.category_id =  10 THEN 17
    WHEN projects.category_id =  11 THEN 7
    WHEN projects.category_id =  12 THEN 23
    WHEN projects.category_id =  13 THEN 4
    WHEN projects.category_id =  14 THEN 20
    WHEN projects.category_id =  15 THEN 8
    WHEN projects.category_id =  16 THEN 6
    WHEN projects.category_id =  17 THEN 5
    WHEN projects.category_id =  18 THEN 6
    WHEN projects.category_id =  19 THEN 8
    WHEN projects.category_id =  20 THEN 14
    WHEN projects.category_id =  21 THEN 14
    WHEN projects.category_id =  22 THEN 14
    ELSE 37
    END
"

];
