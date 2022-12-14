# admin
지니 `사이트 메뉴`는 별도의 admin 페이지를 제공합니다. 


## 메뉴코드 : 복수 메뉴 관리
지니 사이트는 복수의 메뉴 그룹을 생성 관리할 수 있습니다.
메뉴를 생성하기 위해서 먼저 코드를 등록합니다.

메뉴 그룹은 관리자 페이지에서 등록할 수 있습니다.
* /admin/site/menu/code


## 메뉴트리 : 항목 등록
메뉴 그룹페이지에서 `메뉴구조`를 클릭하면 세부 메뉴 항목을 설정할 수 있는 페이지로 이동됩니다.
새로운 항목을 추가하고, 추가된 항목들을 drag and drop 형태로 이동 배치를 쉽게 할 수 있습니다.


### 메뉴 적용하기
생성되 메뉴 구조의 상태는 모두 DB에 저장이 되어 있습니다. DB 테이블명은 `menu_items` 입니다.
DB에 저장된 메뉴구조가 사이트에 바로 적용이 되지 않습니다. 
이는 임시 작업중인 메뉴들이 실제 사이트에 반영되지 안으면서, 쉽게 구조를 변경할 수 있는 장점이 있습니다.

적용을 하기 위해서는 json으로 변환하여 서버에 저장을 하여야 합니다. 변환버튼을 클릭하세요.

### json 파일 관리하기
이렇게 변환된 파일들은 `/resources/menus` 폴더안에 저장이 됩니다. 저장된 파일들은 메뉴 파일 목록에서
확인이 가능합니다. 변경된 json 메뉴 설정파일을 다운로드 할 수 있습니다.

### json 파일 업로드 하기
자신이 가지고 있는 메뉴 json 파일을 `/resources/menus` 폴더안에 올려두어 사용을 할 수도 있으며,
도는 메뉴 항목 생성기에서 업로드하여 json 설정값을 DB에 반영하여 편집할 수도 있습니다.



## json 파일 관리하기
`/admin/site/menu/file`로 접속하면, 변경된 json 파일들을 관리할 수 있습니다.
