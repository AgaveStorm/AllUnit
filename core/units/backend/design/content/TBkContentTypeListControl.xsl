<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TBkContentTypeListControl">
        <div class="content-type-list">
            <ul class="menu-vertical">
                <xsl:for-each select="types/item">
                    <li class="menu-item">
                        <a href="{permalink}">
                            <xsl:value-of select="title"/>
                        </a>
                    </li>
                </xsl:for-each>
            </ul>
        </div>
    </xsl:template>
</xsl:stylesheet>
