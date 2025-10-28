
AGENDUM_SDK_VERSION := 0.1.0

push:
	@git add .
	@git commit -am "Updated at $$(date)" || true
	@git push

release: push
	@git add .
	@git commit -m "Update Agendum SDK to version ${AGENDUM_SDK_VERSION}" || echo "No changes to commit"
	@git tag -fa "v${AGENDUM_SDK_VERSION}" -m "${AGENDUM_SDK_VERSION}"
	@git push origin --tags -f
