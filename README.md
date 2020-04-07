# School Meal API PHP
> 전국 초/중/고등학교/병설유치원 급식 API

본 소스는 php 서버에서 구동되는 백엔드입니다.

전국 교육청 학생 서비스 페이지를 파싱하여 오늘/내일/이번 달 급식 정보를 JSON 데이터로 제공합니다.

## 파라미터 안내
```index.php?moe=???&code=???????????&school+?```
##### 예시 (서울고등학교)
```index.php?moe=sen&code=B100000456&school=4```

### moe
> 소재 교육청 코드

| 지역 | Value |
|:---:|:---|
| 서울 | `sen` |
| 인천 | `ice` |
| 부산 | `pen` |
| 광주 | `gen` |
| 대전 | `dge` |
| 대구 | `dge` |
| 세종 | `sje` |
| 울산 | `use` |
| 경기 | `goe` |
| 강원 | `kwe` |
| 충북 | `cbe` |
| 충남 | `cne` |
| 경북 | `gbe` |
| 경남 | `gne` |
| 전북 | `jbe` |
| 전남 | `jne` |
| 제주 | `jje` |


### code
> 학교 코드

학교 코드는 아래에서 찾으실 수 있습니다.
http://jubsoo2.bscu.ac.kr/src_gogocode/src_gogocode.asp


### school
> 학교 종류

| 유형 | Value |
|:---:|:---:|
| 병설유치원 | 1 |
| 초등학교 | 2 |
| 중학교 | 3 |
| 고등학교 | 4 |
